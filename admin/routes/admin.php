<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\QuoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| All routes here are protected by:
|   - auth          → must be authenticated
|   - admin         → must have is_admin = true  (EnsureUserIsAdmin middleware)
|
| Register in bootstrap/app.php:
|   ->withMiddleware(function (Middleware $middleware) {
|       $middleware->alias(['admin' => \App\Http\Middleware\EnsureUserIsAdmin::class]);
|   })
|
| Then in routes/web.php:
|   require __DIR__.'/admin.php';
|
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        // Dashboard
        Route::get('/', DashboardController::class . '@index')->name('dashboard');

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
    });
