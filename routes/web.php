<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscordTimeInController;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/discord-time-in', [DiscordTimeInController::class, 'index']);
