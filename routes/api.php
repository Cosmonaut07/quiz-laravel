<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuestUserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {

    route::get('ping', function () {
        return response()->json('pong');
    });

    Route::prefix('questions')->group(function () {
        Route::get('/', [QuestionController::class, 'index']);
        Route::post('/', [QuestionController::class, 'store']);
        Route::get('/{id}', [QuestionController::class, 'show']);
        Route::put('/{id}', [QuestionController::class, 'update']);
        Route::delete('/{id}', [QuestionController::class, 'destroy']);
    });

    Route::prefix('guest-users')->group(function () {
        Route::get('/', [GuestUserController::class, 'guestEntries']);
    });
});

Route::middleware('auth:guest')->group(function () {
    Route::prefix('quizes')->group(function () {
        Route::post('start', [QuizController::class, 'startQuiz']);
        Route::post('continue', [QuizController::class, 'continueQuiz']);
        Route::post('submit', [QuizController::class, 'submitQuiz']);
        Route::post('check', [QuizController::class, 'checkAnswer']);
    });
});


Route::prefix('guest-users')->group(function () {
    Route::post('/create', [GuestUserController::class, 'store']);
    Route::get('/leaderboard', [GuestUserController::class, 'leaderboard']);
});
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});





