<?php

namespace App\Services;

use InvalidArgumentException;

class CoursePricingService
{
    public function subtotalFor(string $level): int
    {
        $key = strtolower(trim($level));
        $prices = config('course_pricing.prices', []);

        if (! array_key_exists($key, $prices)) {
            throw new InvalidArgumentException("Unknown course level: {$level}");
        }

        return (int) $prices[$key];
    }

    /** @return array{subtotal:int,admin_fee:int,total:int} */
    public function breakdown(string $level): array
    {
        $subtotal = $this->subtotalFor($level);
        $adminFee = (int) config('course_pricing.admin_fee', 0);

        return [
            'subtotal' => $subtotal,
            'admin_fee' => $adminFee,
            'total' => $subtotal + $adminFee,
        ];
    }
}
