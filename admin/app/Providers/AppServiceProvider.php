<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind ProductService into the container (auto-resolved, but explicit is cleaner)
        $this->app->singleton(\App\Services\ProductService::class);
    }

    public function boot(): void
    {
        // Use our custom Blade pagination view instead of the default Tailwind one
        Paginator::defaultView('admin.components.pagination');

        // Register view paths for anonymous components
        Blade::component('admin.components.delete-button', 'admin.delete-button');
    }
}
