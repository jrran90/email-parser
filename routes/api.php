<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuccessfulEmailController;


Route::post('/login', [AuthController::class, 'login']);
// Note: I skipped creating the registration method, since it will be handled thru seeder.

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('emails', SuccessfulEmailController::class)->except(['create', 'edit']);
});
