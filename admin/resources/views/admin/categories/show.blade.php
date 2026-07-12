@extends('layouts.admin')
@section('title', $category->name)

@section('header-actions')
    <a href="{{ route('admin.categories.edit', $category) }}"
       class="inline-flex items-center gap-2 bg-brand text-gray-50 text-sm font-semibold px-4 py-2 rounded-xl hover:bg-brand-dark transition-colors">
        Edit Category
    </a>
    <a href="{{ route('admin.categories.index') }}"
       class="inline-flex items-center gap-2 bg-gray-800 border border-gray-700 text-gray-300 text-sm font-medium px-4 py-2 rounded-xl hover:bg-gray-700 transition-colors">
        ← Back
    </a>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Category info card --}}
    <div class="lg:col-span-1 space-y-4">
        <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden aspect-video flex items-center justify-center">
            @if($category->imageUrl)
                @php
                    $catUrl = $category->imageUrl;
                    // normalize URL - remove any leading /images/ prefix
                    if (str_starts_with($catUrl, '/images/products/')) {
                        $catUrl = str_replace('/images/products/', 'products/', $catUrl);
                    }
                    $catPath = preg_match('/^https?:\/\//', $catUrl)
                        ? $catUrl
                        : Storage::url($catUrl);
                @endphp
                <img src="{{ $catPath }}" alt="{{ $category->name }}"
                     class="w-full h-full object-cover">
            @else
                <x-image-placeholder size="lg" icon="category" />
            @endif
            <div class="p-6">
                <h2 class="font-display font-extrabold text-xl mb-1">{{ $category->name }}</h2>
                <code class="text-xs text-gray-400">{{ $category->slug }}</code>
                @if($category->description)
                    <p class="mt-3 text-sm text-gray-400 leading-relaxed">{{ $category->description }}</p>
                @endif
                <div class="mt-4 pt-4 border-t border-gray-800 space-y-1.5 text-xs text-gray-400">
                    <div>Created: {{ $category->created_at->format('d M Y, H:i') }}</div>
                    <div>Updated: {{ $category->updated_at->format('d M Y, H:i') }}</div>
                </div>
            </div>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 text-center">
            <div class="font-display text-4xl font-extrabold text-brand">{{ $products->total() }}</div>
            <div class="text-sm text-gray-400 mt-1">Products in this category</div>
        </div>
    </div>

    {{-- Products list --}}
    <div class="lg:col-span-2 bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
            <h3 class="font-display font-bold text-sm">Products</h3>
            <a href="{{ route('admin.products.create') }}"
               class="text-xs text-brand hover:underline">+ Add Product</a>
        </div>
        <table class="w-full text-sm">
            <tbody class="divide-y divide-gray-800">
            @forelse($products as $product)
            <tr class="hover:bg-gray-800/40 transition-colors">
                <td class="px-6 py-3">
                    @if($product->imageUrl)
                        <img src="{{ Storage::url($product->imageUrl) }}" alt="{{ $product->name }}"
                             class="w-9 h-9 rounded-lg object-cover bg-gray-800"
                             onerror="this.style.display='none'">
                    @endif
                </td>
                <td class="px-6 py-3 font-medium text-gray-200">{{ $product->name }}</td>
                <td class="px-6 py-3 font-mono text-xs text-gray-400">{{ $product->slug }}</td>
                <td class="px-6 py-3 text-right">
                    <a href="{{ route('admin.products.edit', $product) }}"
                       class="text-xs text-gray-400 hover:text-brand transition-colors">Edit →</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-12 text-center text-gray-300">No products in this category yet.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-800">
            {{ $products->links('admin.components.pagination') }}
        </div>
    </div>
</div>
@endsection
