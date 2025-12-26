<?php

use App\Http\Controllers\UserController;
use \Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [UserController::class, 'login']);
    Route::get('me', [UserController::class, 'getUserByToken']);
    Route::post('logout', [UserController::class, 'logout']);
});
