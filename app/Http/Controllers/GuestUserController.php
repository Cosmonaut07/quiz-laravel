<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestUserRequest;
use App\Models\QuizEntry;
use App\Models\QuizUserAnswer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GuestUserController extends BaseController
{
    public function guestEntries(): JsonResponse
    {

        $quizEntries = QuizEntry::with('guestUser')
            ->orderBy('id', 'desc')->get();
        return $this->successResponse($quizEntries);

    }

    public function store(GuestUserRequest $request): JsonResponse
    {
        //check if user exists with email
        $guest = User::where('email', $request->email)->first();
        if ($guest) {
            //does name and last name match
            if ($guest->name == $request->name && $guest->last_name == $request->last_name) {
                return $this->successResponse($guest);
            }
            if ($guest->is_admin){
                return $this->errorResponse('Can\'t use this email');
            }

            return $this->errorResponse('Guest already used this email');
        }
        $guestUser = User::create(
            $request->validated()
            + ['password' => now()],
        );

        return $this->successResponse($guestUser);
    }

    public function leaderboard(): JsonResponse
    {
        $quizEntries = QuizEntry::with('guestUser')
            ->orderBy('score', 'desc')
            ->limit(15)->get();
        return $this->successResponse($quizEntries);
    }

}
