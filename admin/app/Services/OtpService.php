<?php

namespace App\Services;

use App\Enums\AuthLogEvent;
use App\Exceptions\OtpDeliveryException;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Handles Steps 2-4 of the authentication flow: generating, delivering and
 * verifying the six-digit email OTP.
 */
class OtpService
{
    private const MAX_ATTEMPTS = 5;

    private const EXPIRY_MINUTES = 10;

    public function __construct(private readonly AuthLogService $authLogService) {}

    /**
     * Generates a new OTP for the user, invalidating any prior unconsumed
     * codes, and emails it via the existing (synchronous) Mailable pattern.
     */
    public function generateAndSend(User $user, Request $request): void
    {
        $user->otps()->whereNull('consumed_at')->delete();

        $plainCode = (string) random_int(100000, 999999);

        $user->otps()->create([
            'code' => Hash::make($plainCode),
            'expires_at' => now()->addMinutes(self::EXPIRY_MINUTES),
        ]);

        try {
            Mail::to($user->email)->send(new OtpMail($plainCode, self::EXPIRY_MINUTES));
        } catch (Throwable $exception) {
            report($exception);

            throw OtpDeliveryException::from($exception);
        }

        $this->authLogService->record(AuthLogEvent::OtpGenerated, $user, $request);
    }

    public function verify(User $user, string $submittedCode, Request $request): bool
    {
        $otp = $user->otps()->whereNull('consumed_at')->latest('id')->first();

        if ($otp === null || $otp->isExpired()) {
            $this->authLogService->record(
                event: AuthLogEvent::OtpFailed,
                user: $user,
                request: $request,
                metadata: ['reason' => $otp === null ? 'no_pending_otp' : 'expired'],
            );

            return false;
        }

        if ($otp->attempts >= self::MAX_ATTEMPTS) {
            $otp->update(['consumed_at' => now()]);

            $this->authLogService->record(
                event: AuthLogEvent::OtpFailed,
                user: $user,
                request: $request,
                metadata: ['reason' => 'max_attempts_exceeded'],
            );

            return false;
        }

        if (! Hash::check($submittedCode, $otp->code)) {
            $otp->increment('attempts');

            if ($otp->fresh()->attempts >= self::MAX_ATTEMPTS) {
                $otp->update(['consumed_at' => now()]);
            }

            $this->authLogService->record(
                event: AuthLogEvent::OtpFailed,
                user: $user,
                request: $request,
                metadata: ['reason' => 'incorrect_code'],
            );

            return false;
        }

        $otp->update(['consumed_at' => now()]);

        $this->authLogService->record(AuthLogEvent::OtpVerified, $user, $request);

        return true;
    }
}
