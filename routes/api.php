<?php

use App\Http\Controllers\Api\V1\InterconnectionController;
use App\Http\Controllers\Api\V1\PopsController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->as('v1')->group(function () {
    Route::prefix('interconnection')->as('interconnection.')->group(function () {
        Route::get('/', [InterconnectionController::class, 'index'])->name('index');
    });

    Route::prefix('pops')->as('pops.')->group(function () {
        Route::get('/', [PopsController::class, 'index'])->name('index');
    });
});
