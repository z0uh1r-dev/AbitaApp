<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AuthLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OtpVerifyRequest;
use App\Models\User;
use App\Services\AuthLogService;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OtpController extends Controller
{
    public function show(): View
    {
        return view('auth.otp');
    }

    /**
     * Step 4. On success: authenticate, regenerate the session ID, clear
     * the pending-OTP state, record last_login_at, and route to the forced
     * password-change screen or the dashboard.
     */
    public function store(OtpVerifyRequest $request, OtpService $otpService, AuthLogService $authLogService): RedirectResponse
    {
        $user = User::findOrFail($request->session()->get('auth.pending_user_id'));

        if (! $otpService->verify($user, $request->validated('code'), $request)) {
            return back()->withErrors(['code' => 'The code you entered is incorrect or has expired.']);
        }

        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->forget(['auth.pending_user_id', 'auth.pending_expires_at']);

        $user->update(['last_login_at' => now()]);

        $authLogService->record(AuthLogEvent::LoginSuccess, $user, $request);

        if ($user->must_change_password) {
            return redirect()->route('password.change.show');
        }

        return redirect()->intended(route('admin.dashboard'));
    }
}
