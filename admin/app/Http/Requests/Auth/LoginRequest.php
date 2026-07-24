<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Format-only validation. Deliberately does NOT check the company
     * domain here — that check is folded into LoginService::attempt() so a
     * wrong-domain email fails with the exact same generic message as a
     * wrong password, rather than a distinguishable 422 validation error.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
