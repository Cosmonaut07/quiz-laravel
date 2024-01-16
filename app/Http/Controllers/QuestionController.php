<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\QuestionChoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends BaseController
{
    public function index(Request $request): JsonResponse
    {
        $questions = Question::query()
            ->with('choices')
            ->when($request->get('type'), function ($query, $value) {
                return $query->whereType($value);
            })->get();
        return $this->successResponse($questions);
    }

    public function store(QuestionRequest $request): JsonResponse
    {
        $questions = Question::create($request->validated());
        foreach ($request->choices as $choice) {
            $questions->choices()->create($choice);
        }
        return $this->successResponse($questions);

    }

    public function show($id): JsonResponse
    {

        $data = Question::where('id', $id)->firstOrFail();

        $data->choices->each(function ($choice) {
            $choice->makeVisible('is_correct');
        });
        return $this->successResponse($data);

    }

    public function update(QuestionRequest $request, $id): JsonResponse
    {

        $questions = Question::find($id);
        $questions->update(
            $request->validated()
        );
        foreach ($request->choices as $choice) {
            $ch = QuestionChoice::find($choice['id']);
            $ch->update($choice);
        }
        return $this->successResponse($questions);

    }

    public function destroy($id): JsonResponse
    {

        $questions = Question::find($id);
        $questions->delete();
        return $this->successResponse($questions);
    }
}
