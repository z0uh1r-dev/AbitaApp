<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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

        Gate::policy(User::class, UserPolicy::class);

        $this->registerRateLimiters();
    }

    private function registerRateLimiters(): void
    {
        // Tight per (ip + email) limit, plus a looser per-ip limit so a
        // single IP can't blunt the first limiter by spraying many emails.
        RateLimiter::for('login', function (Request $request) {
            $email = strtolower((string) $request->input('email'));

            return [
                Limit::perMinute(5)->by($request->ip().'|'.$email),
                Limit::perMinute(20)->by($request->ip()),
            ];
        });

        RateLimiter::for('otp', function (Request $request) {
            $pendingUserId = $request->session()->get('auth.pending_user_id');

            return Limit::perMinute(10)->by($request->ip().'|'.$pendingUserId);
        });
    }
}
