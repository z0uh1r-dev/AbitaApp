<?php

use App\Exceptions\InvalidUserStateTransitionException;
use App\Exceptions\OtpDeliveryException;
use App\Exceptions\ProtectedAccountException;
use App\Http\Middleware\EnsurePendingOtp;
use App\Http\Middleware\EnsureUserIsSuperAdmin;
use App\Http\Middleware\ForcePasswordChange;
use App\Http\Middleware\SetRobotsHeader;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'super_admin' => EnsureUserIsSuperAdmin::class,
            'pending_otp' => EnsurePendingOtp::class,
            'force_password_change' => ForcePasswordChange::class,
        ]);

        // Entire app is a private dashboard — noindex on every response.
        $middleware->append(SetRobotsHeader::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ProtectedAccountException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $e->getMessage()], 403);
            }

            return back()->with('error', $e->getMessage());
        });

        $exceptions->render(function (InvalidUserStateTransitionException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $e->getMessage()], 422);
            }

            return back()->with('error', $e->getMessage());
        });

        $exceptions->render(function (OtpDeliveryException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $e->getMessage()], 503);
            }

            return back()->withErrors(['email' => $e->getMessage()])->onlyInput('email');
        });
    })->create();
