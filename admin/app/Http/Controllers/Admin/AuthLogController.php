<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuthLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthLogController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAuthLogs', User::class);

        $event = $request->string('event')->toString();
        $userId = $request->string('user_id')->toString();
        $from = $request->string('from')->toString();
        $to = $request->string('to')->toString();

        $logs = AuthLog::query()
            ->with('user')
            ->when($event, fn ($q, $value) => $q->where('event', $value))
            ->when($userId, fn ($q, $value) => $q->where('user_id', $value))
            ->when($from, fn ($q, $value) => $q->whereDate('created_at', '>=', $value))
            ->when($to, fn ($q, $value) => $q->whereDate('created_at', '<=', $value))
            ->latest('created_at')
            ->paginate(25)
            ->withQueryString();

        $users = User::orderBy('first_name')->get(['id', 'first_name', 'last_name']);

        return view('admin.auth-logs.index', compact('logs', 'users'));
    }
}
