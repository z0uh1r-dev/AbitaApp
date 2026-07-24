<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Thrown when an action would delete, suspend, or change the role of an
 * `is_protected` account (the seeded Super Administrator / application
 * owner). This is a defense-in-depth guard at the Service layer, in
 * addition to the same rule being enforced by UserPolicy at the HTTP layer.
 */
class ProtectedAccountException extends RuntimeException
{
    public static function cannotModify(string $action): self
    {
        return new self("This account is protected and cannot be {$action}.");
    }
}
