<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionChoice extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'question_id',
            'choice',
            'is_correct',
        ];

    protected $hidden = ['is_correct'];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function scopeWhereQuestionId(Builder $query, $questionId): Builder
    {
        return $query->where('question_id', $questionId);
    }

    public function scopeIsCorrect(Builder $query): Builder
    {
        return $query->where('is_correct', true);
    }
}
