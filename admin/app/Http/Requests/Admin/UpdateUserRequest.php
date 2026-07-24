<?php

namespace App\Http\Requests\Admin;

use App\Enums\UserRole;
use App\Rules\CompanyEmailDomain;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isSuperAdmin();
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', "unique:users,email,{$userId}", new CompanyEmailDomain],
            'role' => ['required', Rule::enum(UserRole::class)],
        ];
    }
}
