<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    protected $table = 'quizzes';

    protected $fillable = [
        'title',
        'image_path',
        'week_label',
        'description',
        'published_at',
        'language',
        'level',
        'duration_minutes',
        'total_questions',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Get the results for this quiz.
     */
    public function results(): HasMany
    {
        return $this->hasMany(QuizResult::class, 'quiz_id');
    }
}
