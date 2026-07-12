@extends('layouts.admin')
@section('title', 'Products')

@section('header-actions')
    <a href="{{ route('admin.products.create') }}"
       class="inline-flex items-center gap-2 bg-brand text-gray-50 text-sm font-semibold px-4 py-2 rounded-xl hover:bg-brand-dark transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Product
    </a>
@endsection

@section('content')

{{-- Filters --}}
<form method="GET" class="mb-6 flex flex-wrap gap-3">
    <div class="relative">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input name="q" value="{{ request('q') }}" placeholder="Search products…"
               class="bg-gray-900 border border-gray-700 rounded-xl pl-9 pr-4 py-2 text-sm text-gray-200 placeholder-gray-600 focus:outline-none focus:ring-1 focus:ring-brand w-64">
    </div>
    <select name="category"
            onchange="this.form.submit()"
            class="bg-gray-900 border border-gray-700 rounded-xl px-3 py-2 text-sm text-gray-300 focus:outline-none focus:ring-1 focus:ring-brand">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
    <button type="submit" class="bg-gray-800 border border-gray-700 text-gray-300 text-sm px-4 py-2 rounded-xl hover:bg-gray-700 transition-colors">Search</button>
    @if(request('q') || request('category'))
        <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-400 hover:text-gray-300 px-3 py-2">Clear</a>
    @endif
</form>

<div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-800">
        <h2 class="font-display font-bold text-sm">
            Products
            <span class="text-gray-400 font-normal">({{ $products->total() }})</span>
        </h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-800">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider w-12"></th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Specs</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Options</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Images</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
            @forelse($products as $product)
            <tr class="hover:bg-gray-800/40 transition-colors">
                <td class="px-6 py-4">
                    @if($product->imageUrl)
                        @php
                            $imgPath = preg_match('/^https?:\/\//', $product->imageUrl)
                                ? $product->imageUrl
                                : Storage::url($product->imageUrl);
                        @endphp
                        <img src="{{ $imgPath }}" alt="{{ $product->name }}"
                             class="w-10 h-10 rounded-lg object-cover bg-gray-800"
                             onerror="this.classList.add('opacity-0')">
                    @else
                        <x-image-placeholder size="md" icon="package" />
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-gray-200">{{ $product->name }}</div>
                    <div class="text-xs font-mono text-gray-400">{{ $product->slug }}</div>
                </td>
                <td class="px-6 py-4">
                    @if($product->category)
                        <a href="{{ route('admin.categories.show', $product->category) }}"
                           class="text-xs bg-gray-800 text-gray-300 px-2.5 py-1 rounded-full hover:text-brand transition-colors">
                            {{ $product->category->name }}
                        </a>
                    @else
                        <span class="text-gray-300">—</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-gray-400 text-xs">{{ $product->specifications_count }}</td>
                <td class="px-6 py-4 text-gray-400 text-xs">{{ $product->customizations_count }}</td>
                <td class="px-6 py-4 text-gray-400 text-xs">{{ $product->images_count }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.products.show', $product) }}"
                           class="text-xs text-gray-400 hover:text-gray-200 transition-colors px-2 py-1.5 rounded-lg hover:bg-gray-800">View</a>
                        <a href="{{ route('admin.products.edit', $product) }}"
                           class="text-xs text-gray-400 hover:text-brand transition-colors px-2 py-1.5 rounded-lg hover:bg-gray-800">Edit</a>
                        <x-admin.delete-button :action="route('admin.products.destroy', $product)"
                            confirm="Delete '{{ $product->name }}'? All specs, options, and images will also be deleted." />
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-16 text-center text-gray-300">
                    <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    No products found
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-800">
        {{ $products->links('admin.components.pagination') }}
    </div>
</div>
@endsection
