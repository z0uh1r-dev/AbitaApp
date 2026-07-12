<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// ── Authentication routes ──
Route::get('/login', [LoginController::class, 'show'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

// ── Public / admin routes ──
Route::get('/', fn() => redirect()->route('admin.dashboard'));

// ── Include admin routes ──
require __DIR__.'/admin.php';

// ── Swagger API Documentation ──
Route::get('/docs.json', [\App\Http\Controllers\SwaggerJsonController::class, 'json']);
