{{-- Modern image placeholder for missing product/category images --}}
@props(['size' => 'md', 'icon' => 'image'])

@php
    $sizeClasses = match($size) {
        'sm'  => 'w-8 h-8',
        'md'  => 'w-10 h-10',
        'lg'  => 'w-16 h-16',
        'xl'  => 'w-20 h-20',
        'full' => 'w-full h-full',
        default => 'w-10 h-10',
    };
    
    $containerClasses = match($size) {
        'sm'  => 'rounded-lg',
        'md'  => 'rounded-lg',
        'lg'  => 'rounded-2xl',
        'xl'  => 'rounded-2xl',
        'full' => 'rounded-2xl',
        default => 'rounded-lg',
    };
    
    $iconClasses = match($size) {
        'sm'  => 'w-4 h-4',
        'md'  => 'w-5 h-5',
        'lg'  => 'w-8 h-8',
        'xl'  => 'w-10 h-10',
        'full' => 'w-12 h-12',
        default => 'w-5 h-5',
    };
@endphp

<div class="flex items-center justify-center {{ $sizeClasses }} {{ $containerClasses }} bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700">
    @if($icon === 'image')
        <svg class="{{ $iconClasses }} text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
    @elseif($icon === 'package')
        <svg class="{{ $iconClasses }} text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
    @elseif($icon === 'category')
        <svg class="{{ $iconClasses }} text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
        </svg>
    @endif
</div>
