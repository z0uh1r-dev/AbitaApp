@extends('layouts.admin')
@section('title', isset($user) ? 'Edit User' : 'New User')

@section('header-actions')
    <a href="{{ route('admin.users.index') }}"
       class="inline-flex items-center gap-2 bg-gray-800 border border-gray-700 text-gray-300 text-sm font-medium px-4 py-2 rounded-xl hover:bg-gray-700 transition-colors">
        ← Back
    </a>
@endsection

@section('content')
<div class="max-w-2xl space-y-6">

    @if($errors->any())
    <div class="bg-red-950 border border-red-800 rounded-xl p-4">
        <ul class="text-sm text-red-400 space-y-1 list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8">
        <h2 class="font-display font-bold text-lg mb-6">
            {{ isset($user) ? 'Edit: ' . $user->full_name : 'Create New User' }}
        </h2>

        <form method="POST"
              action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}">
            @csrf
            @if(isset($user)) @method('PUT') @endif

            <div class="space-y-5">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">
                            First name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="first_name"
                               value="{{ old('first_name', $user->first_name ?? '') }}"
                               required
                               class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-100 focus:outline-none focus:ring-1 focus:ring-brand @error('first_name') border-red-700 @enderror">
                        @error('first_name')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">
                            Last name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="last_name"
                               value="{{ old('last_name', $user->last_name ?? '') }}"
                               required
                               class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-100 focus:outline-none focus:ring-1 focus:ring-brand @error('last_name') border-red-700 @enderror">
                        @error('last_name')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">
                        Email <span class="text-red-500">*</span>
                        <span class="text-gray-300 font-normal normal-case tracking-normal">(must end in @abitaofficedesign.com)</span>
                    </label>
                    <input type="email" name="email"
                           value="{{ old('email', $user->email ?? '') }}"
                           required
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-100 focus:outline-none focus:ring-1 focus:ring-brand @error('email') border-red-700 @enderror">
                    @error('email')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select name="role" required
                            @if(isset($user) && $user->is_protected) disabled @endif
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-100 focus:outline-none focus:ring-1 focus:ring-brand @error('role') border-red-700 @enderror">
                        @foreach(\App\Enums\UserRole::cases() as $role)
                            <option value="{{ $role->value }}" @selected(old('role', $user->role->value ?? 'user') === $role->value)>{{ $role->label() }}</option>
                        @endforeach
                    </select>
                    @if(isset($user) && $user->is_protected)
                        <input type="hidden" name="role" value="{{ $user->role->value }}">
                        <p class="mt-1 text-xs text-gray-500">This account's role is protected and cannot be changed.</p>
                    @endif
                    @error('role')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>

                @unless(isset($user))
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" required
                                   class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-100 focus:outline-none focus:ring-1 focus:ring-brand @error('password') border-red-700 @enderror">
                            @error('password')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">
                                Confirm password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password_confirmation" required
                                   class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-100 focus:outline-none focus:ring-1 focus:ring-brand">
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 -mt-2">
                        At least 12 characters, with uppercase, lowercase, a number and a symbol. The user will be required to change it on first login and will receive a welcome email.
                    </p>
                @else
                    <p class="text-xs text-gray-500">
                        Password isn't changed here — use “Reset Password” or “Force Reset” from the users list.
                    </p>
                @endunless
            </div>

            <div class="mt-8 flex items-center gap-3">
                <button type="submit"
                        class="bg-brand text-gray-50 text-sm font-semibold px-6 py-2.5 rounded-xl hover:bg-brand-dark transition-colors">
                    {{ isset($user) ? 'Update User' : 'Create User' }}
                </button>
                <a href="{{ route('admin.users.index') }}"
                   class="text-sm text-gray-400 hover:text-gray-300 px-4 py-2.5 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
