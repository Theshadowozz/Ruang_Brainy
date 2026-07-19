<?php

namespace App\Services;

use App\Contracts\PaymentGateway;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Schedule;
use App\Models\WaitingList;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PaymentService
{
    public function __construct(
        private readonly CoursePricingService $pricing,
        private readonly PaymentGateway $gateway,
    ) {}

    public function createPayment(Registration $registration, string $type = Payment::TYPE_INITIAL): Payment
    {
        $registration->loadMissing('schedule.courseClass');
        $breakdown = $this->pricing->breakdown($registration->schedule->courseClass->level);

        return Payment::create([
            'registration_id' => $registration->id,
            'type' => $type,
            'subtotal' => $breakdown['subtotal'],
            'admin_fee' => $breakdown['admin_fee'],
            'amount' => $breakdown['total'],
            'payment_method' => 'Midtrans Snap',
            'order_id' => $this->newOrderId($registration, $type),
            'access_token' => Str::random(64),
            'midtrans_status' => 'pending',
            'expires_at' => now()->addHours((int) config('services.midtrans.expiry_hours', 24)),
            'status' => Payment::STATUS_PENDING,
        ]);
    }

    public function snapToken(Payment $payment): string
    {
        if ($payment->status !== Payment::STATUS_PENDING || $payment->isExpired()) {
            throw ValidationException::withMessages([
                'payment' => 'Transaksi ini sudah tidak dapat dibayar. Buat transaksi baru.',
            ]);
        }

        if ($payment->snap_token) {
            return $payment->snap_token;
        }

        return $this->gateway->createSnapToken($payment);
    }

    /** @param array<string, mixed> $payload */
    public function handleNotification(array $payload): Payment
    {
        $orderId = (string) ($payload['order_id'] ?? '');
        $statusCode = (string) ($payload['status_code'] ?? '');
        $grossAmount = (string) ($payload['gross_amount'] ?? '');
        $signature = (string) ($payload['signature_key'] ?? '');
        $serverKey = (string) config('services.midtrans.server_key');
        $expected = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        if ($orderId === '' || $signature === '' || ! hash_equals($expected, $signature)) {
            throw ValidationException::withMessages(['signature_key' => 'Signature Midtrans tidak valid.']);
        }

        return DB::transaction(function () use ($payload, $orderId, $grossAmount, $statusCode) {
            $payment = Payment::query()
                ->where('order_id', $orderId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($this->normalizeAmount($grossAmount) !== (int) $payment->amount) {
                throw ValidationException::withMessages(['gross_amount' => 'Nominal transaksi tidak sesuai.']);
            }

            $transactionStatus = strtolower((string) ($payload['transaction_status'] ?? ''));
            $fraudStatus = strtolower((string) ($payload['fraud_status'] ?? 'accept'));

            $successful = $this->isSuccessful($transactionStatus, $fraudStatus, $statusCode);

            if (($payment->isPaid() && ! $successful) || $payment->isRefunded()) {
                return $payment;
            }

            $payment->forceFill([
                'transaction_code' => (string) ($payload['transaction_id'] ?? $orderId),
                'midtrans_transaction_id' => $payload['transaction_id'] ?? null,
                'midtrans_status' => $transactionStatus ?: null,
                'midtrans_status_code' => $statusCode ?: null,
                'midtrans_fraud_status' => $fraudStatus ?: null,
                'midtrans_payload' => $this->safePayload($payload),
            ]);

            if ($payment->isPaid()) {
                $payment->save();

                return $payment;
            }

            if ($successful) {
                $payment->status = Payment::STATUS_PAID;
                $payment->paid_at = $this->paidAt($payload);
                $payment->save();
                $this->activateRegistration($payment);

                return $payment;
            }

            $payment->status = match ($transactionStatus) {
                'deny', 'failure' => Payment::STATUS_FAILED,
                'cancel', 'expire' => Payment::STATUS_CANCELLED,
                default => Payment::STATUS_PENDING,
            };
            $payment->save();

            return $payment;
        });
    }

    public function promoteWaitingList(WaitingList $waitingList): void
    {
        DB::transaction(function () use ($waitingList) {
            $waitingList = WaitingList::query()->lockForUpdate()->findOrFail($waitingList->id);
            $schedule = Schedule::query()->lockForUpdate()->findOrFail($waitingList->schedule_id);

            abort_unless($waitingList->status === WaitingList::STATUS_WAITING, 422, 'Antrean tidak dapat dipromosikan.');

            $first = WaitingList::query()
                ->where('schedule_id', $schedule->id)
                ->where('status', WaitingList::STATUS_WAITING)
                ->orderBy('queue_number')
                ->lockForUpdate()
                ->first();

            abort_unless($first && (int) $first->id === (int) $waitingList->id, 422, 'Promosikan nomor antrean paling awal terlebih dahulu.');

            $occupied = $schedule->registrations()
                ->where('status', Registration::STATUS_ACCEPTED)
                ->count();
            abort_if($occupied >= $schedule->capacity, 422, 'Belum ada kursi yang tersedia.');

            $registration = Registration::query()
                ->where('user_id', $waitingList->user_id)
                ->where('schedule_id', $schedule->id)
                ->lockForUpdate()
                ->firstOrFail();
            abort_unless($registration->payments()->where('status', Payment::STATUS_PAID)->exists(), 422, 'Pembayaran siswa belum berhasil.');

            $start = now();
            $registration->update([
                'status' => Registration::STATUS_ACCEPTED,
                'access_starts_at' => $start,
                'access_ends_at' => $start->copy()->addMonthNoOverflow(),
                'seat_reserved_until' => null,
            ]);
            $waitingList->update(['status' => WaitingList::STATUS_ACCEPTED]);
            $registration->user->update(['is_active' => true]);
        });
    }

    private function activateRegistration(Payment $payment): void
    {
        $registration = Registration::query()
            ->with(['schedule', 'user'])
            ->lockForUpdate()
            ->findOrFail($payment->registration_id);

        if ($payment->type === Payment::TYPE_RENEWAL) {
            $start = $payment->paid_at ?? now();
            $registration->update([
                'access_starts_at' => $start,
                'access_ends_at' => $start->copy()->addMonthNoOverflow(),
            ]);

            return;
        }

        if ($registration->status === Registration::STATUS_WAITING_LIST) {
            return;
        }

        $occupied = $registration->schedule->registrations()
            ->where('id', '!=', $registration->id)
            ->where('status', Registration::STATUS_ACCEPTED)
            ->count();

        if ($occupied >= $registration->schedule->capacity) {
            $this->moveToWaitingList($registration);

            return;
        }

        $start = $registration->schedule->start_date->copy()->startOfDay();
        $registration->update([
            'status' => Registration::STATUS_ACCEPTED,
            'access_starts_at' => $start,
            'access_ends_at' => $start->copy()->addMonthNoOverflow(),
            'seat_reserved_until' => null,
        ]);
        $registration->user->update(['is_active' => true]);
    }

    private function moveToWaitingList(Registration $registration): void
    {
        $queueNumber = ((int) WaitingList::query()
            ->where('schedule_id', $registration->schedule_id)
            ->lockForUpdate()
            ->max('queue_number')) + 1;

        WaitingList::firstOrCreate([
            'user_id' => $registration->user_id,
            'schedule_id' => $registration->schedule_id,
        ], [
            'full_name' => $registration->full_name,
            'phone_number' => $registration->phone_number,
            'address' => $registration->address,
            'queue_number' => $queueNumber,
            'status' => WaitingList::STATUS_WAITING,
        ]);

        $registration->update([
            'status' => Registration::STATUS_WAITING_LIST,
            'seat_reserved_until' => null,
        ]);
        $registration->user->update(['is_active' => false]);
    }

    private function newOrderId(Registration $registration, string $type): string
    {
        $prefix = $type === Payment::TYPE_RENEWAL ? 'RNW' : 'REG';

        return "RB-{$prefix}-{$registration->id}-".Str::upper((string) Str::ulid());
    }

    private function normalizeAmount(string $amount): int
    {
        return (int) round((float) $amount);
    }

    private function isSuccessful(string $status, string $fraudStatus, string $statusCode): bool
    {
        return $statusCode === '200'
            && in_array($status, ['capture', 'settlement'], true)
            && ($status !== 'capture' || $fraudStatus === 'accept');
    }

    /** @param array<string, mixed> $payload */
    private function paidAt(array $payload): Carbon
    {
        return isset($payload['settlement_time'])
            ? Carbon::parse((string) $payload['settlement_time'])
            : now();
    }

    /** @param array<string, mixed> $payload @return array<string, mixed> */
    private function safePayload(array $payload): array
    {
        unset($payload['signature_key']);

        return $payload;
    }
}
