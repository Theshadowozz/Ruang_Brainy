<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiscussionTopic extends Model
{
    public const CATEGORY_BRAINY = 'brainy';
    public const CATEGORY_KELUHAN = 'keluhan';
    public const CATEGORY_PEMBELAJARAN = 'pembelajaran';

    public const CATEGORIES = [
        self::CATEGORY_BRAINY => 'Seputar Brainy',
        self::CATEGORY_KELUHAN => 'Keluhan',
        self::CATEGORY_PEMBELAJARAN => 'Pembelajaran',
    ];

    protected $fillable = [
        'user_id',
        'category',
        'title',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(DiscussionMessage::class);
    }
}
