<?php


use Illuminate\Support\Facades\Route;



Route::get('/test', function () {
    return response()->json(['message' => 'Det virker!']);
});


Route::middleware('auth.basic')->group(function () {
    Route::get('/protected', function () {
        return response()->json(['message' => 'Adgang via Basic Auth']);
    });

});