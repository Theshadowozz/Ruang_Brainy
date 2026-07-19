<?php

namespace App\Console\Commands;

use App\Contracts\PaymentGateway;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Console\Command;

class ReconcileMidtransPayments extends Command
{
    protected $signature = 'payments:reconcile-midtrans {--limit=50}';

    protected $description = 'Reconcile pending Midtrans payments using Get Status API';

    public function handle(PaymentGateway $gateway, PaymentService $service): int
    {
        $payments = Payment::query()
            ->where('status', Payment::STATUS_PENDING)
            ->whereNotNull('order_id')
            ->oldest()
            ->limit((int) $this->option('limit'))
            ->get();

        foreach ($payments as $payment) {
            try {
                $payload = $gateway->transactionStatus($payment->order_id);
                $payload['signature_key'] = hash('sha512',
                    ($payload['order_id'] ?? '').
                    ($payload['status_code'] ?? '').
                    ($payload['gross_amount'] ?? '').
                    config('services.midtrans.server_key')
                );
                $service->handleNotification($payload);
                $this->line("{$payment->order_id}: reconciled");
            } catch (\Throwable $exception) {
                $this->warn("{$payment->order_id}: {$exception->getMessage()}");
            }
        }

        return self::SUCCESS;
    }
}
