@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

{{-- ── Stat cards ──────────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
    @foreach([
        ['label' => 'Categories',  'value' => $stats['categories'], 'color' => 'text-brand',    'bg' => 'bg-brand/10'],
        ['label' => 'Products',    'value' => $stats['products'],   'color' => 'text-orange-400','bg' => 'bg-orange-500/10'],
        ['label' => 'Quotes',      'value' => $stats['quotes'],     'color' => 'text-sky-400',   'bg' => 'bg-sky-500/10'],
    ] as $stat)
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
        <div class="font-display text-4xl font-extrabold {{ $stat['color'] }} mb-1">{{ $stat['value'] }}</div>
        <div class="text-sm text-gray-400">{{ $stat['label'] }}</div>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- ── Latest Products ─────────────────────────────────────────────── --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
            <h2 class="font-display font-bold text-sm">Latest Products</h2>
            <a href="{{ route('admin.products.index') }}"
               class="text-xs text-brand hover:underline">View all →</a>
        </div>
        <table class="w-full text-sm">
            <tbody class="divide-y divide-gray-800">
            @forelse($latestProducts as $p)
            <tr class="hover:bg-gray-800/50 transition-colors">
                <td class="px-6 py-3 font-medium text-gray-200">{{ $p->name }}</td>
                <td class="px-6 py-3">
                    <span class="bg-gray-800 text-gray-400 text-xs px-2 py-0.5 rounded-full">
                        {{ $p->category?->name ?? '—' }}
                    </span>
                </td>
                <td class="px-6 py-3 text-right">
                    <a href="{{ route('admin.products.edit', $p) }}"
                       class="text-xs text-gray-400 hover:text-brand transition-colors">Edit →</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="px-6 py-8 text-center text-gray-300">No products yet</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── Latest Quotes ────────────────────────────────────────────────── --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
            <h2 class="font-display font-bold text-sm">Latest Quote Requests</h2>
            <a href="{{ route('admin.quotes.index') }}"
               class="text-xs text-brand hover:underline">View all →</a>
        </div>
        <table class="w-full text-sm">
            <tbody class="divide-y divide-gray-800">
            @forelse($latestQuotes as $q)
            <tr class="hover:bg-gray-800/50 transition-colors">
                <td class="px-6 py-3 font-medium text-gray-200">{{ $q->companyName }}</td>
                <td class="px-6 py-3 text-gray-400">{{ $q->contactName }}</td>
                <td class="px-6 py-3 text-gray-300 text-xs">{{ $q->createdAt->format('d M Y') }}</td>
                <td class="px-6 py-3 text-right">
                    <a href="{{ route('admin.quotes.show', $q) }}"
                       class="text-xs text-gray-400 hover:text-brand transition-colors">View →</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-300">No quote requests</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- ── In Progress Quotes ────────────────────────────────────────────────── --}}
@if($inProgressQuotes->count() > 0)
<div class="mt-6 bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
        <h2 class="font-display font-bold text-sm">
            Quotes In Progress
            <span class="text-gray-400 font-normal">({{ $inProgressQuotes->count() }})</span>
        </h2>
        <a href="{{ route('admin.quotes.index', ['status' => 'In Progress']) }}"
           class="text-xs text-brand hover:underline">View all →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-800">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Company</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
            @foreach($inProgressQuotes as $quote)
            <tr class="hover:bg-gray-800/40 transition-colors">
                <td class="px-6 py-4 font-semibold text-gray-200">{{ $quote->companyName }}</td>
                <td class="px-6 py-4 text-gray-300">{{ $quote->contactName }}</td>
                <td class="px-6 py-4">
                    <a href="mailto:{{ $quote->email }}" class="text-brand hover:underline text-xs">{{ $quote->email }}</a>
                </td>
                <td class="px-6 py-4 text-gray-400 text-xs">{{ $quote->phone }}</td>
                <td class="px-6 py-4 text-gray-400 text-xs whitespace-nowrap">
                    {{ $quote->createdAt->format('d M Y, H:i') }}
                </td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('admin.quotes.show', $quote) }}"
                       class="text-xs text-gray-400 hover:text-gray-200 transition-colors px-2 py-1.5 rounded-lg hover:bg-gray-800">
                        View
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
