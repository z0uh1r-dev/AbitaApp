@extends('layouts.admin')
@section('title', 'Change Password')

@section('content')

<div class="max-w-md bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-800">
        <h2 class="font-display font-bold text-sm">
            {{ $forced ? 'Choose a new password' : 'Change password' }}
        </h2>
        @if($forced)
            <p class="mt-1 text-xs text-gray-400">You must set a new password before continuing.</p>
        @endif
    </div>

    <form method="POST" action="{{ route('password.change.update') }}" class="px-6 py-5 space-y-5">
        @csrf
        @method('PUT')

        @unless($forced)
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-300">Current password</label>
                <div class="mt-2">
                    <input type="password" name="current_password" id="current_password" required
                        class="block w-full rounded-lg border border-gray-700 bg-gray-950 px-4 py-2 text-gray-100 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand sm:text-sm">
                    @error('current_password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        @endunless

        <div>
            <label for="password" class="block text-sm font-medium text-gray-300">New password</label>
            <div class="mt-2">
                <input type="password" name="password" id="password" required
                    class="block w-full rounded-lg border border-gray-700 bg-gray-950 px-4 py-2 text-gray-100 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand sm:text-sm">
                @error('password')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gray-500">At least 12 characters, with uppercase, lowercase, a number and a symbol.</p>
            </div>
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirm new password</label>
            <div class="mt-2">
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="block w-full rounded-lg border border-gray-700 bg-gray-950 px-4 py-2 text-gray-100 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand sm:text-sm">
            </div>
        </div>

        <button type="submit"
            class="flex w-full justify-center rounded-lg bg-brand px-4 py-2 text-sm font-semibold text-gray-50 hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 focus:ring-offset-gray-950 transition-colors">
            Update password
        </button>
    </form>
</div>

@endsection
