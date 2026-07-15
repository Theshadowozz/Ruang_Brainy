<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Registration extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_ACCEPTED = 'accepted';

    public const STATUS_REJECTED = 'rejected';

    public const STATUS_WAITING_LIST = 'waiting_list';

    public const STATUS_FINISHED = 'finished';

    protected $fillable = [
        'full_name',
        'user_id',
        'schedule_id',
        'phone_number',
        'address',
        'status',
        'access_starts_at',
        'access_ends_at',
        'seat_reserved_until',
    ];

    protected function casts(): array
    {
        return [
            'access_starts_at' => 'datetime',
            'access_ends_at' => 'datetime',
            'seat_reserved_until' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    /** Compatibility relation for legacy code expecting one payment. */
    public function payment(): HasOne
    {
        return $this->latestPayment();
    }

    public function hasActiveAccess(?CarbonInterface $at = null): bool
    {
        $at ??= now();

        return $this->status === 'accepted'
            && $this->access_starts_at !== null
            && $this->access_ends_at !== null
            && $this->access_starts_at->lessThanOrEqualTo($at)
            && $this->access_ends_at->greaterThanOrEqualTo($at);
    }
}
