<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizEntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'score' => ['required'],
            'unanswered_questions' => ['required'],
            'time_taken' => ['required'],
        ];
    }
}
