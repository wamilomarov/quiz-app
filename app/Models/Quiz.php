<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $uuid
 * @property string $type
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property int $total_score
 * @property Carbon $submitted_at
 * @property ?string $duration
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Collection|Question[] $questions
 * @property Collection|QuizQuestion[] $quizQuestions
 */
class Quiz extends Model
{
    const TYPE_BINARY = 'binary';
    const TYPE_MULTI = 'multi';

    const TYPES = [
        self::TYPE_BINARY => 'Yes/No',
        self::TYPE_MULTI => 'Multiple Answer'
    ];

    protected $fillable = [
        'type',
        'uuid',
        'first_name',
        'last_name',
        'email',
        'total_score',
        'submitted_at',
        'duration',
    ];

    protected $dates = [
        'submitted_at'
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function (Quiz $quiz) {
            $quiz->uuid = Str::uuid();
        });
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, QuizQuestion::class);
    }

    public function quizQuestions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function setQuestions()
    {
        $questions = Question::query()
            ->where('type', $this->type)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        $this->questions()->attach($questions);
    }
}
