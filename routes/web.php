<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;

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



