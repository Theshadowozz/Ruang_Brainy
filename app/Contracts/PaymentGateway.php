<?php

namespace App\Contracts;

use App\Models\Payment;

interface PaymentGateway
{
    public function createSnapToken(Payment $payment): string;

    /** @return array<string, mixed> */
    public function transactionStatus(string $orderId): array;
}
