<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumTopic extends Model
{
    use HasFactory;

    public const CATEGORY_BRAINY = 'brainy';
    public const CATEGORY_KELUHAN = 'keluhan';
    public const CATEGORY_PEMBELAJARAN = 'pembelajaran';

    protected $fillable = [
        'user_id',
        'category',
        'title',
        'body',
    ];

    public static function categories(): array
    {
        return [
            self::CATEGORY_BRAINY => 'Seputar Brainy',
            self::CATEGORY_KELUHAN => 'Keluhan',
            self::CATEGORY_PEMBELAJARAN => 'Pembelajaran',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ForumReply::class)->latest();
    }
}
