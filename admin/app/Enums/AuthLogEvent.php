<?php

namespace App\Enums;

enum AuthLogEvent: string
{
    case LoginSuccess = 'login_success';
    case LoginFailed = 'login_failed';
    case Logout = 'logout';
    case OtpGenerated = 'otp_generated';
    case OtpVerified = 'otp_verified';
    case OtpFailed = 'otp_failed';
    case PasswordReset = 'password_reset';
    case PasswordChanged = 'password_changed';
    case UserCreated = 'user_created';
    case UserUpdated = 'user_updated';
    case UserSuspended = 'user_suspended';
    case UserReactivated = 'user_reactivated';
    case UserDeleted = 'user_deleted';

    public function label(): string
    {
        return match ($this) {
            self::LoginSuccess => 'Successful login',
            self::LoginFailed => 'Failed login',
            self::Logout => 'Logout',
            self::OtpGenerated => 'OTP generated',
            self::OtpVerified => 'OTP verified',
            self::OtpFailed => 'OTP failed',
            self::PasswordReset => 'Password reset',
            self::PasswordChanged => 'Password changed',
            self::UserCreated => 'User created',
            self::UserUpdated => 'User updated',
            self::UserSuspended => 'User suspended',
            self::UserReactivated => 'User reactivated',
            self::UserDeleted => 'User deleted',
        };
    }
}
