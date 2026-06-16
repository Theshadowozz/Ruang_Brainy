<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AudioLesson extends Model
{
    protected $table = 'audio_lessons';

    protected $fillable = [
        'title',
        'language',
        'level',
        'duration',
        'audio_file',
        'transcript',
    ];

    /**
     * Get the listens records for this audio lesson.
     */
    public function listens(): HasMany
    {
        return $this->hasMany(AudioListen::class, 'audio_lesson_id');
    }
}
