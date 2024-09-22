<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\UserController;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(Auth::User()){
        return view('users.dashboard');
    }
    return view('index');
})->name('home');

Route::get('/dashboard', function () {
    return view('users.dashboard');
})->name('dashboard');

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [UserController::class, 'registerView'])->name('register');
Route::post('/register', [UserController::class, 'create'])->name('register');


Route::middleware('auth')->group(function() {
    
    Route::get('/survey', [SurveyController::class, 'get'])->name('survey');
    Route::get('/surveys', [SurveyController::class, 'list'])->name('surveys');

    Route::post('/survey', [SurveyController::class, 'create'])->name('survey');
    Route::get('/survey/{id}', [SurveyController::class, 'show'])->name('survey_show');
    Route::post('/survey/{id}', [SurveyController::class, 'update'])->name('survey_update');
    


    
    Route::post('/survey/{survey}/questions', [QuestionController::class, 'create'])->name('question_add');
    Route::get('/survey/{survey}/questions', [QuestionController::class, 'show'])->name('questions');
    


    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/update', [UserController::class, 'update'])->name('update');
});