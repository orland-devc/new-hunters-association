<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscordTimeInController;

Route::get('/', function () {
    return redirect('discord-time-in');
});

Route::get('/redir', function () {
    return redirect('/admin');
})->name('redir');

Route::get('/discord-time-in', [DiscordTimeInController::class, 'index'])->name('users-time-in');

Route::get('/auth/callback', function (Illuminate\Http\Request $request) {
    // Handle the callback data
    $message = $request->query('message', 'No message provided');
    return view('auth-callback', ['message' => $message]);
});
