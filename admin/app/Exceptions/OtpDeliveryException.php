<?php

namespace App\Exceptions;

use RuntimeException;
use Throwable;

/**
 * Thrown when the OTP email fails to send (mail server unreachable, timed
 * out, rejected, etc). Distinct from a wrong/expired code — this is an
 * infrastructure failure, not a credential problem, so it's fine for the
 * message shown to be specific about "delivery failed" without violating
 * the login flow's user-enumeration protections (it says nothing about
 * whether any particular account exists).
 */
class OtpDeliveryException extends RuntimeException
{
    public static function from(Throwable $previous): self
    {
        return new self(
            'We could not send your verification code right now. Please try again in a few minutes.',
            previous: $previous,
        );
    }
}
