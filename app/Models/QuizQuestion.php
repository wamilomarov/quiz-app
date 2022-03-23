<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $quiz_id
 * @property int $question_id
 * @property boolean $is_correct
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Question $question
 * @property Answer $answer
 */
class QuizQuestion extends Model
{
    protected $fillable = [
        'quiz_id',
        'question_id',
        'is_correct'
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function checkAnswer(int $answerId): bool
    {
        $answer = $this->question
            ->answers
            ->where('id', $answerId)
            ->where('is_correct', true)
            ->first();

        $this->update([
            'is_correct' => !is_null($answer)
        ]);
        return !is_null($answer);
    }
}
