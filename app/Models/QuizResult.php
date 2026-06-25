<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizResult extends Model
{
    protected $table = 'quiz_results';

    protected $fillable = [
        'user_id',
        'quiz_id',
        'answer_text',
        'answered_at',
        'score',
        'completed_at',
    ];

    protected $casts = [
        'answered_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user that achieved this result.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the quiz that this result belongs to.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
