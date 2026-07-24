<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Restricts an email field to the company domain. Used only for
 * admin-facing user create/update forms, where a clear validation error is
 * appropriate — never for the login form, where a domain mismatch must
 * produce the same generic failure as every other credential problem (see
 * LoginService) to avoid leaking an enumeration signal.
 */
class CompanyEmailDomain implements ValidationRule
{
    private const DOMAIN = '@abitaofficedesign.com';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! str_ends_with(strtolower($value), self::DOMAIN)) {
            $fail('The :attribute must be a company '.self::DOMAIN.' address.');
        }
    }
}
