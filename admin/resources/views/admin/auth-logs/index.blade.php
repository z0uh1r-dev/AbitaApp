@extends('layouts.admin')
@section('title', 'Authentication Logs')

@section('content')

{{-- Filters --}}
<form method="GET" class="mb-6 flex flex-wrap gap-3">
    <select name="event" class="bg-gray-900 border border-gray-700 rounded-xl px-3 py-2 text-sm text-gray-200 focus:outline-none focus:ring-1 focus:ring-brand">
        <option value="">All events</option>
        @foreach(\App\Enums\AuthLogEvent::cases() as $event)
            <option value="{{ $event->value }}" @selected(request('event') === $event->value)>{{ $event->label() }}</option>
        @endforeach
    </select>
    <select name="user_id" class="bg-gray-900 border border-gray-700 rounded-xl px-3 py-2 text-sm text-gray-200 focus:outline-none focus:ring-1 focus:ring-brand">
        <option value="">All users</option>
        @foreach($users as $u)
            <option value="{{ $u->id }}" @selected((string) request('user_id') === (string) $u->id)>{{ $u->full_name }}</option>
        @endforeach
    </select>
    <input type="date" name="from" value="{{ request('from') }}"
           class="bg-gray-900 border border-gray-700 rounded-xl px-3 py-2 text-sm text-gray-200 focus:outline-none focus:ring-1 focus:ring-brand">
    <input type="date" name="to" value="{{ request('to') }}"
           class="bg-gray-900 border border-gray-700 rounded-xl px-3 py-2 text-sm text-gray-200 focus:outline-none focus:ring-1 focus:ring-brand">
    <button type="submit" class="bg-gray-800 border border-gray-700 text-gray-300 text-sm px-4 py-2 rounded-xl hover:bg-gray-700 transition-colors">Filter</button>
    @if(request()->hasAny(['event', 'user_id', 'from', 'to']))
        <a href="{{ route('admin.auth-logs.index') }}" class="text-sm text-gray-400 hover:text-gray-300 px-3 py-2">Clear</a>
    @endif
</form>

<div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-800 flex items-center justify-between">
        <h2 class="font-display font-bold text-sm">
            Authentication Log
            <span class="text-gray-400 font-normal">({{ $logs->total() }})</span>
        </h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-800">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Event</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">IP Address</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Browser</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Platform</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">When</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
            @forelse($logs as $log)
            <tr class="hover:bg-gray-800/40 transition-colors">
                <td class="px-6 py-4">
                    <span class="bg-gray-800 text-gray-300 text-xs font-medium px-2.5 py-1 rounded-full">{{ $log->event->label() }}</span>
                </td>
                <td class="px-6 py-4 text-gray-300">
                    {{ $log->user?->full_name ?? $log->email_attempted ?? '—' }}
                </td>
                <td class="px-6 py-4 text-gray-400 font-mono text-xs">{{ $log->ip_address ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-400 text-xs">{{ $log->browser ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-400 text-xs">{{ $log->platform ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-400 text-xs whitespace-nowrap">{{ $log->created_at->format('d M Y, H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-16 text-center text-gray-300">No log entries found</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-800">
        {{ $logs->links('admin.components.pagination') }}
    </div>
</div>
@endsection
