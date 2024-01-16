<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quiz\CheckAnswerRequest;
use App\Http\Requests\Quiz\StartQuizRequest;
use App\Models\Question;
use App\Models\QuestionChoice;
use App\Models\QuizEntry;
use App\Models\QuizUserAnswer;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class QuizController extends BaseController
{

    public function startQuiz(StartQuizRequest $request)
    {
        $quiz = QuizEntry::create([
            'guest_user_id' => Auth::user()->id,
            'quiz_type'     => $request->quiz_type,
            'is_active'     => true,
            'start_time'    => now(),
        ]);

        $questions = Question::with('choices')
            ->whereType($request->quiz_type)
            ->get();

        $data = [
            'questions' => $questions,
            'quiz_id'   => $quiz->id,
        ];
        return $this->successResponse($data);

    }


    protected function calculateScore($quiz, $left)
    {
        $quiz = QuizEntry::find($quiz->id);
        $quizAnswers = QuizUserAnswer::where('quiz_entry_id', $quiz->id)->get();
        $correctAnswers = 0;
        $incorrectAnswers = 0;
        foreach ($quizAnswers as $answer) {
            if (QuestionChoice::where('id', $answer->choice_id)->pluck('is_correct')->first() == 1) {
                $correctAnswers++;
            } else {
                $incorrectAnswers++;
            }
        }
        $answeredQuestions = $quizAnswers->count();
        $unansweredQuestions = $quiz->questions_amount - $answeredQuestions;
        $calculatedScore = ($correctAnswers * 100 + ceil($left/60)) - $unansweredQuestions * 10;
        $quiz->update([
            'score' => $calculatedScore
        ]);
        return $calculatedScore;
    }


    public function submitQuiz()
    {
        $endTime = now();

        $quiz = QuizEntry::getUserActiveQuiz();
        $left = $this->checkTime($quiz->id);
        $score = $this->calculateScore($quiz, $left);
        $quiz->update([
            'is_active'   => false,
            'submit_time' => $endTime,
            'time_left'   => $left
        ]);

        //Deactivate all other attempts if any exist;
        QuizEntry::where('guest_user_id', Auth::user()->id)
            ->where('is_active', true)
            ->update([
                'is_active' => false,
            ]);


        $data = [
            'time_left' => $left,
            'score'     => $score
        ];
        return $this->successResponse($data);
    }

    public function checkAnswer(CheckAnswerRequest $request)
    {
        $quiz = QuizEntry::getUserActiveQuiz();

        $left = $this->checkTime($quiz->id);
        if (!$left) {
            $quiz->is_active = false;
            $quiz->save();
            return $this->errorResponse('Time is up');
        }

        $question_id = $request->question_id;
        $choice_id = $request->choice_id;
        if (!QuizUserAnswer::query()
            ->where('quiz_entry_id', $quiz->id)
            ->where('question_id', $question_id)
            ->exists()) {
            QuizUserAnswer::create([
                'quiz_entry_id' => $quiz->id,
                'question_id'   => $question_id,
                'choice_id'     => $choice_id
            ]);
        } else {
            return $this->errorResponse('You have already answered this question');
        }

        $answer = QuestionChoice::find($choice_id);
        if (!$answer->is_correct) {
            $correct_answer = QuestionChoice::query()
                ->whereQuestionId($question_id)
                ->isCorrect()
                ->first();
        } else {
            $correct_answer = $answer;
        }

        return $this->successResponse([
            'is_correct'     => $answer->is_correct,
            'correct_answer' => $correct_answer,
            'time_left'      => $left
        ]);
    }

    public function checkTime($quizId)
    {
        $quiz = QuizEntry::find($quizId);
        $start = $quiz->start_time;
        $now = Carbon::now();
        $end = $start->addMinutes(config('quiz.quiz_duration_minutes'));

        if ($end->lessThan($now)) {
            return false;
        } else {
            return $end->diffInSeconds($now);
        }
    }

}
