@extends('layouts.admin')
@section('title', $product->name)

@section('header-actions')
    <a href="{{ route('admin.products.edit', $product) }}"
       class="inline-flex items-center gap-2 bg-brand text-gray-50 text-sm font-semibold px-4 py-2 rounded-xl hover:bg-brand-dark transition-colors">
        Edit Product
    </a>
    <a href="{{ route('admin.products.index') }}"
       class="inline-flex items-center gap-2 bg-gray-800 border border-gray-700 text-gray-300 text-sm font-medium px-4 py-2 rounded-xl hover:bg-gray-700 transition-colors">
        ← Back
    </a>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Hero / main image ───────────────────────────────────────────── --}}
    <div class="lg:col-span-1 space-y-4">
        <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden aspect-square flex items-center justify-center">
            @if($product->imageUrl)
                @php
                    $mainUrl = $product->imageUrl;
                    // normalize URL - remove any leading /images/ prefix
                    if (str_starts_with($mainUrl, '/images/products/')) {
                        $mainUrl = str_replace('/images/products/', 'products/', $mainUrl);
                    }
                    $mainPath = preg_match('/^https?:\/\//', $mainUrl)
                        ? $mainUrl
                        : Storage::url($mainUrl);
                @endphp
                <img src="{{ $mainPath }}" alt="{{ $product->name }}"
                     class="w-full h-full object-cover">
            @else
                <x-image-placeholder size="xl" icon="package" />
            @endif
        </div>

        {{-- Product details card --}}
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5">
            <div class="font-display font-extrabold text-xl leading-tight mb-1">{{ $product->name }}</div>
            <code class="text-xs text-gray-400">{{ $product->slug }}</code>
            @if($product->category)
                <div class="mt-2">
                    <a href="{{ route('admin.categories.show', $product->category) }}"
                       class="inline-block text-xs bg-gray-800 text-gray-300 px-2.5 py-1 rounded-full hover:text-brand transition-colors">
                        {{ $product->category->name }}
                    </a>
                </div>
            @endif
            <p class="mt-3 text-sm text-gray-400 leading-relaxed">{{ $product->description }}</p>
            <div class="mt-4 pt-4 border-t border-gray-800 text-xs text-gray-300 space-y-1">
                <div>Created {{ $product->created_at->format('d M Y, H:i') }}</div>
                <div>Updated {{ $product->updated_at->format('d M Y, H:i') }}</div>
            </div>
        </div>

        {{-- Gallery thumbnails --}}
        @if($product->images->count())
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5">
            <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-3">
                Gallery ({{ $product->images->count() }} images)
            </div>
            <div class="grid grid-cols-3 gap-2">
                @foreach($product->images as $img)
                    <div class="relative group">
                        @php
                            $galleryUrl = $img->url;
                            // normalize URL - remove any leading /images/ prefix
                            if (str_starts_with($galleryUrl, '/images/products/')) {
                                $galleryUrl = str_replace('/images/products/', 'products/', $galleryUrl);
                            }
                            $galleryPath = preg_match('/^https?:\/\//', $galleryUrl)
                                ? $galleryUrl
                                : Storage::url($galleryUrl);
                        @endphp
                        <img src="{{ $galleryPath }}" alt="{{ $img->alt }}"
                             class="w-full aspect-square object-cover rounded-lg bg-gray-800"
                             onerror="this.style.opacity='.3'">
                        <div class="absolute top-1 right-1 bg-gray-900/80 text-gray-400 text-[10px] px-1.5 py-0.5 rounded font-mono">
                            #{{ $img->order }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- ── Details: specs + customizations ────────────────────────────── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Specifications --}}
        <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
                <h3 class="font-display font-bold text-sm">
                    Specifications
                    <span class="text-gray-400 font-normal ml-1">({{ $product->specifications->count() }})</span>
                </h3>
            </div>
            @if($product->specifications->count())
            <table class="w-full text-sm">
                <tbody class="divide-y divide-gray-800">
                @foreach($product->specifications as $spec)
                <tr class="hover:bg-gray-800/30 transition-colors">
                    <td class="px-6 py-3 text-gray-400 font-medium w-1/3">{{ $spec->label }}</td>
                    <td class="px-6 py-3 text-gray-200">{{ $spec->value }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @else
            <p class="px-6 py-8 text-sm text-gray-300 text-center">No specifications added.</p>
            @endif
        </div>

        {{-- Customizations --}}
        <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
                <h3 class="font-display font-bold text-sm">
                    Customization Options
                    <span class="text-gray-400 font-normal ml-1">({{ $product->customizations->count() }})</span>
                </h3>
            </div>
            @if($product->customizations->count())
            <div class="px-6 py-4 flex flex-wrap gap-2">
                @foreach($product->customizations as $custom)
                    <span class="inline-flex items-center gap-1.5 bg-gray-800 border border-gray-700 text-gray-300 text-xs px-3 py-1.5 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand"></span>
                        {{ $custom->label }}
                    </span>
                @endforeach
            </div>
            @else
            <p class="px-6 py-8 text-sm text-gray-300 text-center">No customization options added.</p>
            @endif
        </div>

        {{-- Danger zone --}}
        <div class="bg-gray-900 border border-red-900/50 rounded-2xl p-6">
            <h3 class="font-display font-bold text-sm text-red-400 mb-3">Danger Zone</h3>
            <p class="text-xs text-gray-400 mb-4">Deleting a product will also remove all its specifications, customization options, and gallery images. This action cannot be undone.</p>
            <x-admin.delete-button
                :action="route('admin.products.destroy', $product)"
                label="Delete this product"
                confirm="Delete '{{ $product->name }}' permanently? This will also remove all specs, options, and images." />
        </div>
    </div>

</div>
@endsection
