<?php

namespace App\Services;

use App\Contracts\PaymentGateway;
use App\Models\Payment;
use InvalidArgumentException;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransPaymentGateway implements PaymentGateway
{
    public function __construct()
    {
        Config::$serverKey = (string) config('services.midtrans.server_key');
        Config::$clientKey = (string) config('services.midtrans.client_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production', false);
        Config::$isSanitized = (bool) config('services.midtrans.is_sanitized', true);
        Config::$is3ds = (bool) config('services.midtrans.is_3ds', true);
    }

    public function createSnapToken(Payment $payment): string
    {
        if (! $payment->order_id) {
            throw new InvalidArgumentException('Payment must have an order_id before creating Snap token.');
        }

        $payment->loadMissing('registration.user', 'registration.schedule.courseClass');
        $registration = $payment->registration;
        $customer = $registration?->user;
        $course = $registration?->schedule?->courseClass;

        $response = Snap::createTransaction([
            'transaction_details' => [
                'order_id' => $payment->order_id,
                'gross_amount' => (int) $payment->amount,
            ],
            'item_details' => [
                [
                    'id' => 'course-'.$registration?->schedule_id,
                    'price' => (int) $payment->subtotal,
                    'quantity' => 1,
                    'name' => $course?->name ?? 'Course registration',
                ],
                [
                    'id' => 'admin-fee',
                    'price' => (int) $payment->admin_fee,
                    'quantity' => 1,
                    'name' => 'Administration fee',
                ],
            ],
            'customer_details' => [
                'first_name' => $customer?->name ?? $registration?->full_name ?? 'Student',
                'email' => $customer?->email,
                'phone' => $registration?->phone_number,
            ],
        ]);

        $token = (string) ($response->token ?? '');
        if ($token === '') {
            throw new \RuntimeException('Midtrans did not return a Snap token.');
        }

        $payment->forceFill([
            'snap_token' => $token,
            'snap_token_created_at' => now(),
        ])->save();

        return $token;
    }

    public function transactionStatus(string $orderId): array
    {
        $response = Transaction::status($orderId);

        return is_object($response) ? get_object_vars($response) : (array) $response;
    }
}
