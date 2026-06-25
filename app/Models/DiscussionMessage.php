<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscussionMessage extends Model
{
    protected $fillable = [
        'discussion_topic_id',
        'user_id',
        'body',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(DiscussionTopic::class, 'discussion_topic_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
