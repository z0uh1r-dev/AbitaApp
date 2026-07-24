@extends('layouts.admin')
@section('title', 'Profile')

@section('content')

<div class="max-w-xl bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-800">
        <h2 class="font-display font-bold text-sm">My Profile</h2>
    </div>
    <dl class="divide-y divide-gray-800">
        <div class="px-6 py-4 flex justify-between text-sm">
            <dt class="text-gray-400">First name</dt>
            <dd class="text-gray-200 font-medium">{{ $user->first_name }}</dd>
        </div>
        <div class="px-6 py-4 flex justify-between text-sm">
            <dt class="text-gray-400">Last name</dt>
            <dd class="text-gray-200 font-medium">{{ $user->last_name }}</dd>
        </div>
        <div class="px-6 py-4 flex justify-between text-sm">
            <dt class="text-gray-400">Email</dt>
            <dd class="text-gray-200 font-medium">{{ $user->email }}</dd>
        </div>
        <div class="px-6 py-4 flex justify-between text-sm">
            <dt class="text-gray-400">Role</dt>
            <dd class="text-gray-200 font-medium">{{ $user->role->label() }}</dd>
        </div>
        <div class="px-6 py-4 flex justify-between text-sm">
            <dt class="text-gray-400">Last login</dt>
            <dd class="text-gray-200 font-medium">{{ $user->last_login_at?->format('d M Y, H:i') ?? '—' }}</dd>
        </div>
    </dl>
    <div class="px-6 py-4 border-t border-gray-800">
        <a href="{{ route('password.change.show') }}" class="text-sm text-brand hover:underline">Change password →</a>
    </div>
</div>

@endsection
