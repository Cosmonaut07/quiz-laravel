<?php

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class QuizEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_user_id',
        'is_active',
        'quiz_type',
        'score',
        'start_time',
        'submit_time',
    ];

    protected $appends = [
        'questions_amount',
        'correct_answers_amount',
        'answered_questions_amount',
        'unanswered_questions_amount',
        'time_taken',
    ];

    protected $casts = [
        'start_time'  => 'datetime',
        'submit_time' => 'datetime',
    ];


    public function guestUser()
    {
        return $this->belongsTo(User::class);
    }

    public function quizUserAnswers()
    {
        return $this->hasMany(QuizUserAnswer::class);
    }

    public function choices()
    {
        return $this->hasManyThrough(QuestionChoice::class, QuizUserAnswer::class, 'quiz_entry_id', 'id', 'id', 'choice_id');
    }

    public function getQuestionsAmountAttribute()
    {
        return Question::where('question_type', $this->quiz_type)->count();
    }

    public function getTimeTakenAttribute()
    {
        return Carbon::parse($this->submit_time)->diff(Carbon::parse($this->start_time))->format('%H:%I:%S');
    }

    public function getCorrectAnswersAmountAttribute()
    {
        return $this->choices()->where('is_correct', true)->count();
    }

    public function getAnsweredQuestionsAmountAttribute()
    {
        return $this->quizUserAnswers()->count();
    }

    public function getUnansweredQuestionsAmountAttribute()
    {
        return $this->getQuestionsAmountAttribute() - $this->getAnsweredQuestionsAmountAttribute();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function getUserActiveQuiz()
    {
        return QuizEntry::where('guest_user_id', auth()->user()->id)
            ->active()
            ->latest()
            ->firstOrFail();
    }

}
