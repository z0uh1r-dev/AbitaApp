<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Redirects any authenticated user still flagged `must_change_password` to
 * the change-password screen, on every request except that screen itself
 * and logout (otherwise: redirect loop).
 */
class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user?->must_change_password && ! $request->routeIs('password.change.*') && ! $request->routeIs('logout')) {
            return redirect()->route('password.change.show');
        }

        return $next($request);
    }
}
