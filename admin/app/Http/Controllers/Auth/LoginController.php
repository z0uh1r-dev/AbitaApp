<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\LoginService;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function show(): View
    {
        return view('auth.login');
    }

    /**
     * Step 1 of the authentication flow. On success the user is NOT logged
     * in yet — LoginService starts a pending-OTP session state and this
     * dispatches the OTP (Steps 2-3), leaving verification (Step 4) to
     * OtpController.
     */
    public function store(LoginRequest $request, LoginService $loginService, OtpService $otpService): RedirectResponse
    {
        $credentials = $request->validated();

        $user = $loginService->attempt($credentials['email'], $credentials['password'], $request);

        if ($user === null) {
            return back()
                ->withErrors(['email' => LoginService::GENERIC_ERROR])
                ->onlyInput('email');
        }

        $otpService->generateAndSend($user, $request);

        return redirect()->route('otp.show');
    }
}
