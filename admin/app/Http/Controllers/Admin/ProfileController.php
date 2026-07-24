<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Read-only profile view for the currently authenticated user (both
     * roles). Password changes go through PasswordChangeController.
     */
    public function show(): View
    {
        return view('admin.profile.show', ['user' => auth()->user()]);
    }
}
