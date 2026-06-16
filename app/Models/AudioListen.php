<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AudioListen extends Model
{
    protected $table = 'audio_listens';

    protected $fillable = [
        'user_id',
        'audio_lesson_id',
        'listened_at',
    ];

    protected $casts = [
        'listened_at' => 'datetime',
    ];

    /**
     * Get the user that listened to the audio lesson.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the audio lesson that was listened to.
     */
    public function audioLesson(): BelongsTo
    {
        return $this->belongsTo(AudioLesson::class, 'audio_lesson_id');
    }
}
