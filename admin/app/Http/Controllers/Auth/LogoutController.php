<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AuthLogEvent;
use App\Http\Controllers\Controller;
use App\Services\AuthLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function destroy(Request $request, AuthLogService $authLogService): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($user) {
            $authLogService->record(AuthLogEvent::Logout, $user, $request);
        }

        return redirect('/');
    }
}
