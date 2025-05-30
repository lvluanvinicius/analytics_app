<?php

use App\Http\Controllers\Integration\SignInController;
use Illuminate\Support\Facades\Route;

Route::get('login', [SignInController::class, 'index'])->name('login');
Route::post('login', [SignInController::class, 'store'])->name('login.store');

require __DIR__ . '/application.php';
