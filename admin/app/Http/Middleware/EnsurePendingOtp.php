<?php

namespace App\Http\Middleware;

use App\Enums\UserStatus;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Guards the OTP-entry route (Steps 2-4). Only sessions that just passed
 * Step 1 (LoginService::attempt) may reach it, and only within the pending
 * window — otherwise back to /login.
 */
class EnsurePendingOtp
{
    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->session()->get('auth.pending_user_id');
        $expiresAt = $request->session()->get('auth.pending_expires_at');

        $expired = $expiresAt === null || now()->timestamp > $expiresAt;
        $user = $userId ? User::find($userId) : null;

        if ($userId === null || $expired || $user === null || $user->status !== UserStatus::Active) {
            $request->session()->forget(['auth.pending_user_id', 'auth.pending_expires_at']);

            return redirect()->route('login')->withErrors([
                'email' => 'Your session has expired. Please sign in again.',
            ]);
        }

        return $next($request);
    }
}
