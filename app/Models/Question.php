<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $text
 * @property string $type
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Collection|Answer[] $answers
 */
class Question extends Model
{
    protected $fillable = [
        'text',
        'type',
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
