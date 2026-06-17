<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    protected $table = 'quizzes';

    protected $fillable = [
        'title',
        'language',
        'level',
        'duration_minutes',
        'total_questions',
    ];

    /**
     * Get the questions for this quiz.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class, 'quiz_id');
    }

    /**
     * Get the results for this quiz.
     */
    public function results(): HasMany
    {
        return $this->hasMany(QuizResult::class, 'quiz_id');
    }
}
