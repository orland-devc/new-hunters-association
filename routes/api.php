<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscordTimeInController;

Route::post('/time-in', [DiscordTimeInController::class, 'store']);

Route::post('/time-out', [DiscordTimeInController::class, 'timeOut']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// create a route for testing and return a json response
Route::get('/test', function () {
    return '<h1 style="font-family: Poppins">Hello World!</h1>';
});
