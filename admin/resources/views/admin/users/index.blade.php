@extends('layouts.admin')
@section('title', 'Users')

@section('header-actions')
    <a href="{{ route('admin.users.create') }}"
       class="inline-flex items-center gap-2 bg-brand text-gray-50 text-sm font-semibold px-4 py-2 rounded-xl hover:bg-brand-dark transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New User
    </a>
@endsection

@section('content')

{{-- Search & filters --}}
<form method="GET" class="mb-6 flex flex-wrap gap-3">
    <div class="relative">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input name="q" value="{{ request('q') }}" placeholder="Search name or email…"
               class="bg-gray-900 border border-gray-700 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-200 placeholder-gray-600 focus:outline-none focus:ring-1 focus:ring-brand w-72">
    </div>
    <select name="role" class="bg-gray-900 border border-gray-700 rounded-xl px-3 py-2 text-sm text-gray-200 focus:outline-none focus:ring-1 focus:ring-brand">
        <option value="">All roles</option>
        @foreach(\App\Enums\UserRole::cases() as $role)
            <option value="{{ $role->value }}" @selected(request('role') === $role->value)>{{ $role->label() }}</option>
        @endforeach
    </select>
    <select name="status" class="bg-gray-900 border border-gray-700 rounded-xl px-3 py-2 text-sm text-gray-200 focus:outline-none focus:ring-1 focus:ring-brand">
        <option value="">All statuses</option>
        @foreach(\App\Enums\UserStatus::cases() as $status)
            <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
        @endforeach
    </select>
    <button type="submit" class="bg-gray-800 border border-gray-700 text-gray-300 text-sm px-4 py-2 rounded-xl hover:bg-gray-700 transition-colors">Filter</button>
    @if(request('q') || request('role') || request('status'))
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-400 hover:text-gray-300 px-3 py-2">Clear</a>
    @endif
</form>

<div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-800 flex items-center justify-between">
        <h2 class="font-display font-bold text-sm">
            All Users
            <span class="text-gray-400 font-normal">({{ $users->total() }})</span>
        </h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-800">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Last Login</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Updated</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
            @forelse($users as $user)
            <tr class="hover:bg-gray-800/40 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-semibold text-gray-200">{{ $user->full_name }}</div>
                    @if($user->is_protected)
                        <span class="text-[10px] uppercase tracking-wide text-brand">Protected owner account</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-gray-400">{{ $user->email }}</td>
                <td class="px-6 py-4">
                    <span class="bg-gray-800 text-gray-300 text-xs font-medium px-2.5 py-1 rounded-full">{{ $user->role->label() }}</span>
                </td>
                <td class="px-6 py-4">
                    @php
                        $statusColor = match($user->status) {
                            \App\Enums\UserStatus::Active => 'bg-green-950 text-green-300 border-green-800',
                            \App\Enums\UserStatus::Suspended => 'bg-yellow-950 text-yellow-300 border-yellow-800',
                            \App\Enums\UserStatus::Deleted => 'bg-red-950 text-red-300 border-red-800',
                        };
                    @endphp
                    <span class="text-xs font-medium px-2.5 py-1 rounded-full border {{ $statusColor }}">{{ $user->status->label() }}</span>
                </td>
                <td class="px-6 py-4 text-gray-400 text-xs">{{ $user->last_login_at?->format('d M Y, H:i') ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-400 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4 text-gray-400 text-xs">{{ $user->updated_at->format('d M Y') }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-1.5 flex-wrap">
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="text-xs text-gray-400 hover:text-brand transition-colors px-2 py-1.5 rounded-lg hover:bg-gray-800">
                            Edit
                        </a>

                        @if(! $user->is_protected)
                            @if($user->status === \App\Enums\UserStatus::Suspended)
                                <form method="POST" action="{{ route('admin.users.reactivate', $user) }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-green-400 hover:text-green-300 transition-colors px-2 py-1.5 rounded-lg hover:bg-gray-800">Reactivate</button>
                                </form>
                            @elseif($user->status === \App\Enums\UserStatus::Active)
                                <form method="POST" action="{{ route('admin.users.suspend', $user) }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-yellow-400 hover:text-yellow-300 transition-colors px-2 py-1.5 rounded-lg hover:bg-gray-800">Suspend</button>
                                </form>
                            @endif
                        @endif

                        <form method="POST" action="{{ route('admin.users.force-password-reset', $user) }}"
                              onsubmit="return confirm('Require {{ $user->full_name }} to change their password at next login?')">
                            @csrf
                            <button type="submit" class="text-xs text-gray-400 hover:text-gray-200 transition-colors px-2 py-1.5 rounded-lg hover:bg-gray-800">Force Reset</button>
                        </form>

                        @if(! $user->is_protected)
                            <x-admin.delete-button
                                :action="route('admin.users.destroy', $user)"
                                confirm="Delete '{{ $user->full_name }}'? This cannot be undone." />
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-16 text-center text-gray-300">No users found</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-800">
        {{ $users->links('admin.components.pagination') }}
    </div>
</div>
@endsection
