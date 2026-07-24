<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * The forced first-login password change does not require the current
     * password (the user just proved identity via email + password + OTP
     * moments ago); the self-service change screen does.
     */
    public function rules(): array
    {
        $forced = (bool) $this->user()->must_change_password;

        return [
            'current_password' => $forced ? ['nullable'] : ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::min(12)->mixedCase()->numbers()->symbols(),
            ],
        ];
    }
}
