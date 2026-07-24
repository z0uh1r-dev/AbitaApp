<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\PasswordChangeController;
use Illuminate\Support\Facades\Route;

// ── Authentication routes (Steps 1-4) ──
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:login');

    Route::middleware('pending_otp')->group(function () {
        Route::get('/login/otp', [OtpController::class, 'show'])->name('otp.show');
        Route::post('/login/otp', [OtpController::class, 'store'])->name('otp.verify')->middleware('throttle:otp');
    });
});

Route::middleware(['auth', 'force_password_change'])->group(function () {
    Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');

    Route::get('/password/change', [PasswordChangeController::class, 'show'])->name('password.change.show');
    Route::put('/password/change', [PasswordChangeController::class, 'update'])->name('password.change.update');
});

// ── Public / admin routes ──
Route::get('/', fn () => redirect()->route('admin.dashboard'));

// ── Include admin routes ──
require __DIR__.'/admin.php';

// ── Swagger API Documentation ──
Route::get('/docs.json', [\App\Http\Controllers\SwaggerJsonController::class, 'json']);
