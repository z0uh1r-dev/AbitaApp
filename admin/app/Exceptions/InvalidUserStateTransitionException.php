<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Thrown when a user-management action is attempted against an account in
 * the wrong status (e.g. reactivating an account that isn't suspended).
 */
class InvalidUserStateTransitionException extends RuntimeException
{
    //
}
