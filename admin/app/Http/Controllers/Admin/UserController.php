<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResetUserPasswordRequest;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Services\UserManagementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(private readonly UserManagementService $userManagementService) {}

    public function index(Request $request): View
    {
        $this->authorize('viewAny', User::class);

        $search = $request->string('q')->toString();
        $role = $request->string('role')->toString();
        $status = $request->string('status')->toString();

        $users = User::query()
            ->when($search, fn ($q, $term) => $q->where(fn ($q2) => $q2
                ->where('first_name', 'like', "%{$term}%")
                ->orWhere('last_name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
            ))
            ->when($role, fn ($q, $value) => $q->where('role', $value))
            ->when($status, fn ($q, $value) => $q->where('status', $value))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        $this->authorize('create', User::class);

        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->userManagementService->create($request->validated(), $request->user(), $request);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created — a welcome email with their initial credentials has been sent.');
    }

    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $this->userManagementService->update($user, $request->validated(), $request->user(), $request);

        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $this->userManagementService->delete($user, $request->user(), $request);

        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }

    public function suspend(Request $request, User $user): RedirectResponse
    {
        $this->authorize('suspend', $user);

        $this->userManagementService->suspend($user, $request->user(), $request);

        return back()->with('success', 'User suspended.');
    }

    public function reactivate(Request $request, User $user): RedirectResponse
    {
        $this->authorize('reactivate', $user);

        $this->userManagementService->reactivate($user, $request->user(), $request);

        return back()->with('success', 'User reactivated.');
    }

    public function resetPassword(ResetUserPasswordRequest $request, User $user): RedirectResponse
    {
        $this->authorize('resetPassword', $user);

        $this->userManagementService->resetPassword($user, $request->validated('password'), $request->user(), $request);

        return back()->with('success', 'Password reset — the new password has been emailed to the user.');
    }

    public function forcePasswordReset(Request $request, User $user): RedirectResponse
    {
        $this->authorize('forcePasswordReset', $user);

        $this->userManagementService->forcePasswordReset($user, $request->user(), $request);

        return back()->with('success', 'The user will be required to change their password at next login.');
    }
}
