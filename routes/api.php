<?php

use App\Http\Controllers\Analytics\AuthController;
use App\Http\Controllers\Analytics\EquipamentController;
use App\Http\Controllers\Analytics\GponOnusController;
use App\Http\Controllers\Analytics\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('analytics')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('user/create', [UserController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::prefix('equipaments')->as('equipaments.')->group(function () {
            Route::get('/', [EquipamentController::class, 'index'])->name('index');
            Route::post('/', [EquipamentController::class, 'store'])->name('store');
        });

        Route::prefix('onus')->as('onus.')->group(function () {
            Route::get('/', [GponOnusController::class, 'index'])->name('index');
            Route::get('/names', [GponOnusController::class, 'names'])->name('names');
            // Route::get('/get-dates', [GponGetDatesController::class, 'getDates'])->name('get.dates');
            // Route::get('/zbx-get-dates', [GponGetDatesController::class, 'zbxGetDates'])->name('zbx.get.dates');
            // Route::get('/onus-per-port', [GponOnusPerPortsController::class, 'onusPerPorts'])->name('onus.per.ports');
            // Route::get('/onus-per-port/before-date', [GponOnusPerPortsController::class, 'onusPerPortsBeforeDate'])->name('onus.per.ports');
            Route::get('/datas-onus', [GponOnusController::class, 'onusDatasPerPeriod'])->name('datasOnus');
        });

    });
});