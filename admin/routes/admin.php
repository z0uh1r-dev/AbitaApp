<?php

use App\Http\Controllers\Admin\AuthLogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Every route here requires an authenticated, active user (auth) whose
| password isn't pending a forced change (force_password_change).
|
| Dashboard and Profile are available to both roles (User permissions:
| login, logout, dashboard, profile, change own password). Everything
| else — content management, user management, auth logs — additionally
| requires the super_admin middleware (EnsureUserIsSuperAdmin), and the
| per-target nuances (e.g. protected accounts) are enforced by UserPolicy
| inside the relevant controllers.
|
| Registered in bootstrap/app.php:
|   $middleware->alias([
|       'super_admin' => EnsureUserIsSuperAdmin::class,
|       'force_password_change' => ForcePasswordChange::class,
|   ]);
|
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'force_password_change'])
    ->group(function () {

        // Dashboard & Profile — both roles
        Route::get('/', DashboardController::class.'@index')->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

        // Everything below — Super Administrator only
        Route::middleware('super_admin')->group(function () {
            // Categories – full CRUD
            Route::resource('categories', CategoryController::class);

            // Products – full CRUD
            Route::resource('products', ProductController::class);

            // Quotes – index, show, destroy only (no create/edit)
            Route::resource('quotes', QuoteController::class)
                ->only(['index', 'show', 'update', 'destroy']);

            // Contact messages – index, show, destroy only (no create/edit)
            Route::resource('messages', ContactMessageController::class)
                ->only(['index', 'show', 'destroy']);

            // User management
            Route::resource('users', UserController::class)->except(['show']);
            Route::post('users/{user}/suspend', [UserController::class, 'suspend'])->name('users.suspend');
            Route::post('users/{user}/reactivate', [UserController::class, 'reactivate'])->name('users.reactivate');
            Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
            Route::post('users/{user}/force-password-reset', [UserController::class, 'forcePasswordReset'])->name('users.force-password-reset');

            // Authentication logs
            Route::get('auth-logs', [AuthLogController::class, 'index'])->name('auth-logs.index');
        });
    });
