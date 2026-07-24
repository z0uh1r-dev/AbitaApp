<?php

namespace App\Services;

use App\Enums\AuthLogEvent;
use App\Enums\UserStatus;
use App\Exceptions\InvalidUserStateTransitionException;
use App\Exceptions\ProtectedAccountException;
use App\Mail\AccountReactivatedMail;
use App\Mail\AccountSuspendedMail;
use App\Mail\PasswordResetMail;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * All Super-Administrator user-management actions. Controllers stay thin
 * and only handle HTTP concerns (validation via Form Requests, authorization
 * via UserPolicy); every business rule and side effect (logging, email
 * dispatch, protected-account guards) lives here.
 */
class UserManagementService
{
    public function __construct(private readonly AuthLogService $authLogService) {}

    /**
     * Creates a new user via the full onboarding workflow. Only ever called
     * for admin-created "future users" — the three predefined accounts are
     * seeded directly and never pass through this method.
     */
    public function create(array $data, User $actor, Request $request): User
    {
        $plainPassword = $data['password'];

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $plainPassword,
            'role' => $data['role'],
            'status' => UserStatus::Active,
            'must_change_password' => true,
        ]);

        Mail::to($user->email)->send(new WelcomeMail($user, $plainPassword));

        $this->authLogService->record(
            event: AuthLogEvent::UserCreated,
            user: $user,
            request: $request,
            metadata: ['performed_by' => $actor->id],
        );

        return $user;
    }

    public function update(User $target, array $data, User $actor, Request $request): User
    {
        if ($target->is_protected && isset($data['role']) && $data['role'] !== $target->role->value) {
            throw ProtectedAccountException::cannotModify('assigned a different role');
        }

        $target->fill([
            'first_name' => $data['first_name'] ?? $target->first_name,
            'last_name' => $data['last_name'] ?? $target->last_name,
            'email' => $data['email'] ?? $target->email,
            'role' => $target->is_protected ? $target->role->value : ($data['role'] ?? $target->role->value),
        ])->save();

        $this->authLogService->record(
            event: AuthLogEvent::UserUpdated,
            user: $target,
            request: $request,
            metadata: ['performed_by' => $actor->id],
        );

        return $target->refresh();
    }

    public function suspend(User $target, User $actor, Request $request): User
    {
        if ($target->is_protected) {
            throw ProtectedAccountException::cannotModify('suspended');
        }

        $target->update(['status' => UserStatus::Suspended]);

        Mail::to($target->email)->send(new AccountSuspendedMail($target));

        $this->authLogService->record(
            event: AuthLogEvent::UserSuspended,
            user: $target,
            request: $request,
            metadata: ['performed_by' => $actor->id],
        );

        return $target;
    }

    public function reactivate(User $target, User $actor, Request $request): User
    {
        if ($target->status !== UserStatus::Suspended) {
            throw new InvalidUserStateTransitionException('Only suspended accounts can be reactivated.');
        }

        $target->update(['status' => UserStatus::Active]);

        Mail::to($target->email)->send(new AccountReactivatedMail($target));

        $this->authLogService->record(
            event: AuthLogEvent::UserReactivated,
            user: $target,
            request: $request,
            metadata: ['performed_by' => $actor->id],
        );

        return $target;
    }

    public function delete(User $target, User $actor, Request $request): User
    {
        if ($target->is_protected) {
            throw ProtectedAccountException::cannotModify('deleted');
        }

        $target->update(['status' => UserStatus::Deleted]);

        $this->authLogService->record(
            event: AuthLogEvent::UserDeleted,
            user: $target,
            request: $request,
            metadata: ['performed_by' => $actor->id],
        );

        return $target;
    }

    /**
     * Immediate admin-initiated password reset: the user can log in with
     * the new password right away (unlike forcePasswordReset below).
     */
    public function resetPassword(User $target, string $newPassword, User $actor, Request $request): User
    {
        $target->update([
            'password' => $newPassword,
            'must_change_password' => false,
        ]);

        Mail::to($target->email)->send(new PasswordResetMail($target, $newPassword));

        $this->authLogService->record(
            event: AuthLogEvent::PasswordReset,
            user: $target,
            request: $request,
            metadata: ['performed_by' => $actor->id],
        );

        return $target;
    }

    /**
     * Flags the account so the user must change their (still-valid)
     * password at their next login. Reuses `must_change_password`, the same
     * flag driving new-user onboarding — no duplicated mechanism. Not in
     * the spec's notification list, so no email is sent for this action.
     */
    public function forcePasswordReset(User $target, User $actor, Request $request): User
    {
        $target->update(['must_change_password' => true]);

        $this->authLogService->record(
            event: AuthLogEvent::UserUpdated,
            user: $target,
            request: $request,
            metadata: ['performed_by' => $actor->id, 'action' => 'force_password_reset'],
        );

        return $target;
    }
}
