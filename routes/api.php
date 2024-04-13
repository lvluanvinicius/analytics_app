<?php

use App\Http\Controllers\Analytics\AuthController;
use App\Http\Controllers\Analytics\GponOnusController;
use App\Http\Controllers\Analytics\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('analytics')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('user/create', [UserController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::prefix('equipaments')->group(function () {
            Route::get('', [GponOnusController::class, 'index']);
        });
    });
});