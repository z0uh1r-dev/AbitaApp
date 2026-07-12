@extends('layouts.admin')
@section('title', 'Categories')

@section('header-actions')
    <a href="{{ route('admin.categories.create') }}"
       class="inline-flex items-center gap-2 bg-brand text-gray-50 text-sm font-semibold px-4 py-2 rounded-xl hover:bg-brand-dark transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Category
    </a>
@endsection

@section('content')

{{-- Search --}}
<form method="GET" class="mb-6 flex gap-3">
    <div class="relative">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input name="q" value="{{ request('q') }}" placeholder="Search categories…"
               class="bg-gray-900 border border-gray-700 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-200 placeholder-gray-600 focus:outline-none focus:ring-1 focus:ring-brand w-72">
    </div>
    <button type="submit" class="bg-gray-800 border border-gray-700 text-gray-300 text-sm px-4 py-2 rounded-xl hover:bg-gray-700 transition-colors">Search</button>
    @if(request('q'))
        <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-400 hover:text-gray-300 px-3 py-2">Clear</a>
    @endif
</form>

<div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-800 flex items-center justify-between">
        <h2 class="font-display font-bold text-sm">
            All Categories
            <span class="text-gray-400 font-normal">({{ $categories->total() }})</span>
        </h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-800">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Products</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
            @forelse($categories as $category)
            <tr class="hover:bg-gray-800/40 transition-colors group">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        @if($category->imageUrl)
                            @php
                                $catPath = preg_match('/^https?:\/\//', $category->imageUrl)
                                    ? $category->imageUrl
                                    : Storage::url($category->imageUrl);
                            @endphp
                            <img src="{{ $catPath }}" alt="{{ $category->name }}"
                                 class="w-10 h-10 rounded-lg object-cover bg-gray-800"
                                 onerror="this.style.display='none'">
                        @else
                            <x-image-placeholder size="md" icon="category" />
                        @endif
                        <div>
                            <div class="font-semibold text-gray-200">{{ $category->name }}</div>
                            @if($category->description)
                                <div class="text-xs text-gray-400 truncate max-w-xs">{{ Str::limit($category->description, 60) }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 font-mono text-xs text-gray-400">{{ $category->slug }}</td>
                <td class="px-6 py-4">
                    <span class="bg-gray-800 text-gray-300 text-xs font-medium px-2.5 py-1 rounded-full">
                        {{ $category->products_count }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-400 text-xs">{{ $category->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.categories.show', $category) }}"
                           class="text-xs text-gray-400 hover:text-gray-200 transition-colors px-2 py-1.5 rounded-lg hover:bg-gray-800">
                            View
                        </a>
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="text-xs text-gray-400 hover:text-brand transition-colors px-2 py-1.5 rounded-lg hover:bg-gray-800">
                            Edit
                        </a>
                        <x-admin.delete-button
                            :action="route('admin.categories.destroy', $category)"
                            confirm="Delete '{{ $category->name }}'? This cannot be undone." />
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-16 text-center text-gray-300">
                    <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    No categories found
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-800">
        {{ $categories->links('admin.components.pagination') }}
    </div>
</div>
@endsection
