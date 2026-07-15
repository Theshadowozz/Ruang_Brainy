<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Registration;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class PaymentController extends Controller
{
    public function show(Request $request, Registration $registration, Payment $payment)
    {
        $this->authorizePayment($request, $registration, $payment);
        $registration->load(['user', 'schedule.courseClass.tutor', 'latestPayment', 'payments']);

        return view('registration.payment', [
            'registration' => $registration,
            'payment' => $payment,
            'snapUrl' => config('services.midtrans.is_production')
                ? 'https://app.midtrans.com/snap/snap.js'
                : 'https://app.sandbox.midtrans.com/snap/snap.js',
            'clientKey' => config('services.midtrans.client_key'),
        ]);
    }

    public function start(Request $request, Registration $registration, Payment $payment, PaymentService $service)
    {
        $this->authorizePayment($request, $registration, $payment);

        try {
            $token = $service->snapToken($payment);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Midtrans belum dapat membuka pembayaran. Periksa konfigurasi atau coba lagi.',
            ], 422);
        }

        return response()->json(['token' => $token]);
    }

    public function status(Request $request, Registration $registration, Payment $payment)
    {
        $this->authorizePayment($request, $registration, $payment);
        $payment->refresh();

        return response()->json([
            'status' => $payment->status,
            'midtrans_status' => $payment->midtrans_status,
            'redirect_url' => $this->paymentUrl($registration, $payment),
        ]);
    }

    public function renew(Request $request, Registration $registration, PaymentService $service)
    {
        abort_unless($request->user()?->is($registration->user), 403);
        abort_unless($registration->status === Registration::STATUS_ACCEPTED, 422, 'Kelas ini tidak dapat diperpanjang.');

        $payment = DB::transaction(function () use ($registration, $service) {
            $registration = Registration::query()->lockForUpdate()->findOrFail($registration->id);
            $pending = $registration->payments()
                ->where('type', Payment::TYPE_RENEWAL)
                ->where('status', Payment::STATUS_PENDING)
                ->where(fn ($query) => $query->whereNull('expires_at')->orWhere('expires_at', '>', now()))
                ->latest()
                ->first();

            return $pending ?: $service->createPayment($registration, Payment::TYPE_RENEWAL);
        });

        $request->session()->put('registration_id', $registration->id);

        return redirect($this->paymentUrl($registration, $payment));
    }

    public function retry(Request $request, Registration $registration, Payment $payment, PaymentService $service)
    {
        $this->authorizePayment($request, $registration, $payment);
        abort_unless(in_array($payment->status, [Payment::STATUS_FAILED, Payment::STATUS_CANCELLED], true) || $payment->isExpired(), 422);

        $replacement = DB::transaction(fn () => $service->createPayment($registration, $payment->type));

        return redirect($this->paymentUrl($registration, $replacement));
    }

    private function authorizePayment(Request $request, Registration $registration, Payment $payment): void
    {
        abort_unless($payment->registration_id === $registration->id, 404);

        $sessionOwner = (int) $request->session()->get('registration_id') === $registration->id;
        $authenticatedOwner = $request->user()?->is($registration->user) ?? false;
        $signedAccess = $request->hasValidSignature()
            && hash_equals((string) $payment->access_token, (string) $request->query('access_token'));

        abort_unless($sessionOwner || $authenticatedOwner || $signedAccess, 403);
    }

    public function paymentUrl(Registration $registration, Payment $payment): string
    {
        return URL::temporarySignedRoute(
            'registration.payment.show',
            now()->addDays(7),
            [
                'registration' => $registration,
                'payment' => $payment,
                'access_token' => $payment->access_token,
            ]
        );
    }
}
