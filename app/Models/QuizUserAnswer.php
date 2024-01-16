<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizUserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_entry_id',
        'question_id',
        'choice_id',
    ];

    public function quizEntry(){
        return $this->belongsTo(QuizEntry::class);
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function choice(){
        return $this->belongsTo(QuestionChoice::class);
    }


}
