@extends('layouts.admin')
@section('title', 'Contact Messages')

@section('content')

<form method="GET" class="mb-6 flex gap-3">
    <div class="relative">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input name="q" value="{{ request('q') }}" placeholder="Search by name, company, email, phone…"
               class="bg-gray-900 border border-gray-700 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-200 placeholder-gray-600 focus:outline-none focus:ring-1 focus:ring-brand w-80">
    </div>
    <button type="submit" class="bg-gray-800 border border-gray-700 text-gray-300 text-sm px-4 py-2 rounded-xl hover:bg-gray-700 transition-colors">Search</button>
    @if(request('q'))
        <a href="{{ route('admin.messages.index') }}" class="text-sm text-gray-400 hover:text-gray-300 px-3 py-2">Clear</a>
    @endif
</form>

<div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-800">
        <h2 class="font-display font-bold text-sm">
            Contact Messages
            <span class="text-gray-400 font-normal">({{ $messages->total() }})</span>
        </h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-800">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Company</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
            @forelse($messages as $message)
            <tr class="hover:bg-gray-800/40 transition-colors">
                <td class="px-6 py-4 font-semibold text-gray-200">{{ $message->fullName }}</td>
                <td class="px-6 py-4 text-gray-300">{{ $message->companyName }}</td>
                <td class="px-6 py-4">
                    <a href="mailto:{{ $message->email }}" class="text-brand hover:underline">{{ $message->email }}</a>
                </td>
                <td class="px-6 py-4 text-gray-400">{{ $message->phone }}</td>
                <td class="px-6 py-4 text-gray-400 text-xs whitespace-nowrap">
                    {{ $message->createdAt->format('d M Y, H:i') }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.messages.show', $message) }}"
                           class="text-xs text-gray-400 hover:text-gray-200 transition-colors px-2 py-1.5 rounded-lg hover:bg-gray-800">
                            View
                        </a>
                        <x-admin.delete-button :action="route('admin.messages.destroy', $message)"
                            confirm="Delete this message from {{ $message->fullName }}?" />
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-16 text-center text-gray-300">
                    <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    No contact messages yet
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-800">
        {{ $messages->links('admin.components.pagination') }}
    </div>
</div>
@endsection
