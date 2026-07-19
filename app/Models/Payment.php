<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    public const TYPE_INITIAL = 'initial';

    public const TYPE_RENEWAL = 'renewal';

    public const STATUS_PENDING = 'pending';

    public const STATUS_PAID = 'paid';

    public const STATUS_FAILED = 'failed';

    public const STATUS_CANCELLED = 'cancelled';

    public const MIDTRANS_SUCCESS_STATUSES = ['capture', 'settlement'];

    protected $fillable = [
        'registration_id',
        'type',
        'subtotal',
        'admin_fee',
        'amount',
        'payment_method',
        'transaction_code',
        'order_id',
        'access_token',
        'snap_token',
        'snap_token_created_at',
        'midtrans_transaction_id',
        'midtrans_status',
        'midtrans_status_code',
        'midtrans_fraud_status',
        'midtrans_payload',
        'expires_at',
        'refund_id',
        'refund_amount',
        'refund_requested_at',
        'refund_note',
        'refunded_at',
        'payment_proof',
        'status',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'admin_fee' => 'decimal:2',
            'amount' => 'decimal:2',
            'refund_amount' => 'decimal:2',
            'midtrans_payload' => 'array',
            'snap_token_created_at' => 'datetime',
            'expires_at' => 'datetime',
            'refund_requested_at' => 'datetime',
            'refunded_at' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function isRefunded(): bool
    {
        return $this->refunded_at !== null;
    }
}
