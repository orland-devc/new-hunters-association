<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscordTimeInController;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/discord-time-in', [DiscordTimeInController::class, 'index']);

Route::get('/auth/callback', function (Illuminate\Http\Request $request) {
    // Handle the callback data
    $message = $request->query('message', 'No message provided');
    return view('auth-callback', ['message' => $message]);
});
