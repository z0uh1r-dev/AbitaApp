<?php

namespace App\Services;

use App\Enums\AuthLogEvent;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Handles Step 1 of the authentication flow: email + password.
 *
 * Every possible failure reason (unknown email, wrong domain, wrong
 * password, suspended/deleted account) is folded into a single outcome so
 * the HTTP layer can return one identical generic message — preventing user
 * enumeration. The real reason is still recorded internally via AuthLogService
 * for the Super Administrator's audit log.
 *
 * On success, no Laravel session is authenticated yet: the user is only
 * "pending OTP" until Step 4 succeeds (see OtpService).
 */
class LoginService
{
    public const GENERIC_ERROR = 'These credentials do not match our records.';

    private const COMPANY_DOMAIN = '@abitaofficedesign.com';

    public function __construct(private readonly AuthLogService $authLogService) {}

    public function attempt(string $email, string $password, Request $request): ?User
    {
        $user = User::where('email', $email)->first();

        $failureReason = match (true) {
            $user === null => 'user_not_found',
            ! str_ends_with(strtolower($email), self::COMPANY_DOMAIN) => 'invalid_domain',
            ! Hash::check($password, $user->password) => 'invalid_password',
            $user->status !== UserStatus::Active => 'account_'.$user->status->value,
            default => null,
        };

        if ($failureReason !== null) {
            $this->authLogService->record(
                event: AuthLogEvent::LoginFailed,
                user: $user,
                request: $request,
                emailAttempted: $email,
                metadata: ['reason' => $failureReason],
            );

            return null;
        }

        $this->beginPendingOtpState($user, $request);

        return $user;
    }

    private function beginPendingOtpState(User $user, Request $request): void
    {
        // Regenerate the session ID as soon as the trust level changes
        // (anonymous -> pending 2FA), on top of the spec's explicit
        // requirement to regenerate again after OTP success in Step 4.
        $request->session()->regenerate();

        $request->session()->put('auth.pending_user_id', $user->id);
        $request->session()->put('auth.pending_expires_at', now()->addMinutes(10)->timestamp);
    }
}
