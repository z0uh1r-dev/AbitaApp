<?php

namespace App\Policies;

use App\Models\User;

/**
 * Every ability requires the Super Administrator role. `delete`/`suspend`
 * additionally block `is_protected` targets (the seeded owner account) at
 * the authorization layer — UserManagementService enforces the same rule
 * again as defense-in-depth.
 */
class UserPolicy
{
    public function viewAny(User $actor): bool
    {
        return $actor->isSuperAdmin();
    }

    public function view(User $actor, User $target): bool
    {
        return $actor->isSuperAdmin();
    }

    public function create(User $actor): bool
    {
        return $actor->isSuperAdmin();
    }

    public function update(User $actor, User $target): bool
    {
        return $actor->isSuperAdmin();
    }

    public function delete(User $actor, User $target): bool
    {
        return $actor->isSuperAdmin() && ! $target->is_protected;
    }

    public function suspend(User $actor, User $target): bool
    {
        return $actor->isSuperAdmin() && ! $target->is_protected;
    }

    public function reactivate(User $actor, User $target): bool
    {
        return $actor->isSuperAdmin();
    }

    public function resetPassword(User $actor, User $target): bool
    {
        return $actor->isSuperAdmin();
    }

    public function forcePasswordReset(User $actor, User $target): bool
    {
        return $actor->isSuperAdmin();
    }

    public function viewAuthLogs(User $actor): bool
    {
        return $actor->isSuperAdmin();
    }
}
