<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * AdminPolicy – gates every admin route.
 *
 * In production replace the simple `is_admin` flag with whatever
 * role/permission system the project uses (Spatie, Gates, etc.).
 */
class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Called before all other methods.
     * Admins pass everything; non-admins fall through to per-method checks.
     */
    public function before(User $user): ?bool
    {
        return $user->is_admin ? true : null;
    }

    public function viewAny(User $user): bool  { return false; }
    public function view(User $user): bool      { return false; }
    public function create(User $user): bool    { return false; }
    public function update(User $user): bool    { return false; }
    public function delete(User $user): bool    { return false; }
}
