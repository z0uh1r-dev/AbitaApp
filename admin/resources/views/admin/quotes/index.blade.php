@extends('layouts.admin')
@section('title', 'Quote Requests')

@section('content')

<form method="GET" class="mb-6 flex gap-3">
    <div class="relative">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input name="q" value="{{ request('q') }}" placeholder="Search by company, name, email…"
               class="bg-gray-900 border border-gray-700 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-200 placeholder-gray-600 focus:outline-none focus:ring-1 focus:ring-brand w-80">
    </div>
    <select name="status" class="bg-gray-900 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:outline-none focus:ring-1 focus:ring-brand">
        <option value="">All Statuses</option>
        <option value="New" @if(request('status') === 'New') selected @endif>New</option>
        <option value="In Progress" @if(request('status') === 'In Progress') selected @endif>In Progress</option>
        <option value="Completed" @if(request('status') === 'Completed') selected @endif>Completed</option>
    </select>
    <button type="submit" class="bg-gray-800 border border-gray-700 text-gray-300 text-sm px-4 py-2 rounded-xl hover:bg-gray-700 transition-colors">Filter</button>
    @if(request('q') || request('status'))
        <a href="{{ route('admin.quotes.index') }}" class="text-sm text-gray-400 hover:text-gray-300 px-3 py-2">Clear</a>
    @endif
</form>

<div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-800">
        <h2 class="font-display font-bold text-sm">
            Quote Requests
            <span class="text-gray-400 font-normal">({{ $quotes->total() }})</span>
        </h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-800">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Company</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
            @forelse($quotes as $quote)
            <tr class="hover:bg-gray-800/40 transition-colors">
                <td class="px-6 py-4 font-semibold text-gray-200">{{ $quote->companyName }}</td>
                <td class="px-6 py-4 text-gray-300">{{ $quote->contactName }}</td>
                <td class="px-6 py-4">
                    <a href="mailto:{{ $quote->email }}" class="text-brand hover:underline">{{ $quote->email }}</a>
                </td>
                <td class="px-6 py-4 text-gray-400">{{ $quote->phone }}</td>
                <td class="px-6 py-4">
                    @if($quote->status === 'New')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                            New
                        </span>
                    @elseif($quote->status === 'In Progress')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">
                            In Progress
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">
                            Completed
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-gray-400 text-xs whitespace-nowrap">
                    {{ $quote->createdAt->format('d M Y, H:i') }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.quotes.show', $quote) }}"
                           class="text-xs text-gray-400 hover:text-gray-200 transition-colors px-2 py-1.5 rounded-lg hover:bg-gray-800">
                            View
                        </a>
                        <x-admin.delete-button :action="route('admin.quotes.destroy', $quote)"
                            confirm="Delete this quote from {{ $quote->companyName }}?" />
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-16 text-center text-gray-300">
                    <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    No quote requests yet
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-800">
        {{ $quotes->links('admin.components.pagination') }}
    </div>
</div>
@endsection
