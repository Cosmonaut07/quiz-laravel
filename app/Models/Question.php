<?php

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'question_type',
    ];


    protected $casts = [
        'question_type' => QuestionType::class,
    ];

    public function choices(): HasMany
    {
        return $this->hasMany(QuestionChoice::class);
    }


    public function scopeWhereType(Builder $query, $type): Builder
    {
        return $query->where('question_type', $type);
    }

}
