<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionOptionController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyResultController;
use App\Http\Controllers\UserController;
use App\Models\SurveyResult;
use Illuminate\Support\Facades\Route;



Route::get('/test', function () {
    return response()->json(['message' => 'Det virker!']);
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'create']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout/all', [AuthController::class, 'logout_all']);

    Route::get('/survey/{id}', [SurveyController::class, 'get'])->name('survey');
    Route::get('/survey', [SurveyController::class, 'list'])->name('surveys');
    Route::post('/survey', [SurveyController::class, 'create'])->name('survey');
    Route::put('/survey/{id}', [SurveyController::class, 'update'])->name('survey_update');
    Route::post('/survey/submit-answer', [SurveyResultController::class, 'submitAnswer']);

    Route::post('/question', [QuestionController::class, 'create']);
    Route::get('/question/{id}', [QuestionController::class, 'get']);
    Route::delete('/question/{id}', [QuestionController::class, 'delete'])->name('question_delete');
    Route::put('/question/{id}', [QuestionController::class, 'update'])->name('question_update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/update', [UserController::class, 'update'])->name('update');

    Route::prefix('questions/{questionId}/options')->group(function () {
        Route::get('/', [QuestionOptionController::class, 'index']); 
        Route::get('/{id}', [QuestionOptionController::class, 'show']); 
        Route::post('/', [QuestionOptionController::class, 'store']); 
        Route::put('/{id}', [QuestionOptionController::class, 'update']); 
        Route::delete('/{id}', [QuestionOptionController::class, 'destroy']);
    });
});