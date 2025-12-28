<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\JwtAuthenticateMiddleware;
use \Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [UserController::class, 'getUserAuthData']);

    Route::middleware(JwtAuthenticateMiddleware::class)->group(function () {
        Route::get('me', [UserController::class, 'getUserByToken']);
        Route::post('logout', [UserController::class, 'logout']);
    });
});

Route::middleware(JwtAuthenticateMiddleware::class)->group(function () {
    Route::apiResource('projects', ProjectController::class);
    Route::patch('projects/{project}/status', [ProjectController::class, 'setStatus']);
});

