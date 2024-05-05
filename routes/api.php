<?php

use App\Http\Controllers\Analytics\AuthController;
use App\Http\Controllers\Analytics\EquipamentController;
use App\Http\Controllers\Analytics\GponOnusController;
use App\Http\Controllers\Analytics\InterconnectionController;
use App\Http\Controllers\Analytics\PopsController;
use App\Http\Controllers\Analytics\PortsController;
use App\Http\Controllers\Analytics\ProxmoxController;
use App\Http\Controllers\Analytics\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:1000,1')->prefix('analytics')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    // Route::post('user/create', [UserController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::prefix('users')->as('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('/', [UserController::class, 'register'])->name('register');
            Route::put('/{userid}', [UserController::class, 'update'])->name('update');
            Route::delete('/{userid}', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('equipaments')->as('equipaments.')->group(function () {
            Route::get('/', [EquipamentController::class, 'index'])->name('index');
            Route::post('/', [EquipamentController::class, 'store'])->name('store');
        });

        Route::prefix('ports')->as('ports.')->group(function () {
            Route::get('/{equipament_name}', [PortsController::class, 'index'])->name('index');
        });

        Route::prefix('onus')->as('onus.')->group(function () {
            Route::get('/', [GponOnusController::class, 'index'])->name('index');
            Route::get('/names', [GponOnusController::class, 'names'])->name('names');
            Route::get('/get-dates', [GponOnusController::class, 'getDates'])->name('get.dates');
            Route::get('/datas-onus', [GponOnusController::class, 'onusDatasPerPeriod'])->name('datasOnus');
            Route::get('/onus-per-port', [GponOnusController::class, 'onusPerPorts'])->name('onus.per.ports');
            Route::get('/zbx-report-equipament/{equipament}', [GponOnusController::class, 'zbxReportEquipament'])->name('zbx.report.equipament');
            // Route::get('/zbx-get-dates', [GponGetDatesController::class, 'zbxGetDates'])->name('zbx.get.dates');
            // Route::get('/onus-per-port/before-date', [GponOnusPerPortsController::class, 'onusPerPortsBeforeDate'])->name('onus.per.ports');
        });

        Route::prefix('pops')->as('pops.')->group(function () {
            Route::get('/', [PopsController::class, 'index'])->name('index');
        });

        Route::prefix('interconnection')->as('interconnection.')->group(function () {
            Route::get('/', [InterconnectionController::class, 'index'])->name('index');
        });

        Route::prefix('proxmox')->as('proxmox.')->group(function () {
            Route::post('/request-all', [ProxmoxController::class, 'requestApp'])->name('index');
        });

    });
});
