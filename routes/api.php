<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get('/test', function () {
    return response()->json(['message' => 'Det virker!']);
});
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'create'])->name('register');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/survey/{id}', [SurveyController::class, 'get'])->name('survey');
    Route::get('/surveys', [SurveyController::class, 'list'])->name('surveys');
    Route::post('/survey', [SurveyController::class, 'create'])->name('survey');
    Route::put('/survey/{id}', [SurveyController::class, 'update'])->name('survey_update');

    Route::post('/survey/{survey}/question', [QuestionController::class, 'create'])->name('question_add');
    Route::delete('/survey/{survey_id}/question/{id}', [QuestionController::class, 'delete'])->name('question_delete');
    Route::put('/question/{id}', [QuestionController::class, 'update'])->name('question_update');
    Route::get('/survey/{survey}/question', [QuestionController::class, 'show'])->name('questions');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/update', [UserController::class, 'update'])->name('update');


});