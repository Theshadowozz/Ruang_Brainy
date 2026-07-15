<?php

return [
    'currency' => 'IDR',
    'admin_fee' => (int) env('PAYMENT_ADMIN_FEE', 2500),
    'prices' => [
        'beginner' => 350000,
        'intermediate' => 375000,
        'advance' => 400000,
    ],
];
