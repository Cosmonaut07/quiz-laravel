<?php

namespace App\Http\Controllers;

use App\Models\QuestionChoice;
use Illuminate\Http\Request;

class QuestionChoiceController extends BaseController
{
    public function index(){
        $questions = QuestionChoice::all();
        return $this->successResponse($questions);
    }

    public function store(QuestionChoice $request){

        $questionChoices = QuestionChoice::create([
            $request->validated()
        ]);

        return $this->successResponse($questionChoices);
    }

    public function show($id){

        $data = QuestionChoice::find($id);
        return $this->successResponse($data);
    }

    public function update(QuestionChoice $request, $id){

        $questionChoices = QuestionChoice::find($id);
        $questionChoices->update([
            $request->validated()
        ]);
        return $this->successResponse($questionChoices);

    }

    public function destroy($id){

        $questionChoices = QuestionChoice::find($id);
        $questionChoices->delete();
        return $this->successResponse($questionChoices);

    }

}
