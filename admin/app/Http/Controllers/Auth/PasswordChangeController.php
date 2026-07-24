<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AuthLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Services\AuthLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PasswordChangeController extends Controller
{
    public function show(): View
    {
        return view('auth.change-password', [
            'forced' => (bool) auth()->user()->must_change_password,
        ]);
    }

    public function update(ChangePasswordRequest $request, AuthLogService $authLogService): RedirectResponse
    {
        $user = $request->user();

        $user->update([
            'password' => $request->validated('password'),
            'must_change_password' => false,
        ]);

        $authLogService->record(AuthLogEvent::PasswordChanged, $user, $request);

        return redirect()->route('admin.dashboard')->with('success', 'Your password has been updated.');
    }
}
