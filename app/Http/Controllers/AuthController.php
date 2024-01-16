<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Faker\Provider\Base;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function login(LoginRequest $request): JsonResponse
    {

        $loginUserData = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|min:8'
        ]);
        $user = User::where('email', $loginUserData['email'])->first();

        if (!$user || !Hash::check($loginUserData['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        return $this->successResponse([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ], 'Successfully logged in');

    }
}
