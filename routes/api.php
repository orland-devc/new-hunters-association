<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscordTimeInController;
use App\Http\Controllers\SecureDataController;
use App\Http\Controllers\PayslipController;

Route::post('/payslip/confirm', [PayslipController::class, 'confirmPayslip']);
Route::post('/payslip/appeal', [PayslipController::class, 'appealPayslip']);

Route::post('/oauth/token', [\Laravel\Passport\Http\Controllers\AccessTokenController::class, 'issueToken']);

Route::post('/time-in', [DiscordTimeInController::class, 'store']);

Route::post('/time-out', [DiscordTimeInController::class, 'timeOut']);

Route::get('/secure-data', [SecureDataController::class, 'index']);


// create a route for testing and return a json response
Route::get('/test', function () {
    return '<h1 style="font-family: Poppins">Hello World!</h1>';
});
