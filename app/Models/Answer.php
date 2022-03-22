<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $question_id
 * @property boolean $is_correct
 * @property string $text
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Question $question
 */
class Answer extends Model
{
    protected $fillable = [
        'question_id',
        'text',
        'is_correct'
    ];

    protected $casts = [
        'is_correct' => 'boolean'
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
