@extends('layouts.admin')
@section('title', isset($category) ? 'Edit Category' : 'New Category')

@section('header-actions')
    <a href="{{ route('admin.categories.index') }}"
       class="inline-flex items-center gap-2 bg-gray-800 border border-gray-700 text-gray-300 text-sm font-medium px-4 py-2 rounded-xl hover:bg-gray-700 transition-colors">
        ← Back
    </a>
@endsection

@section('content')
<div class="max-w-2xl">

    @if($errors->any())
    <div class="mb-6 bg-red-950 border border-red-800 rounded-xl p-4">
        <ul class="text-sm text-red-400 space-y-1 list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8">
        <h2 class="font-display font-bold text-lg mb-6">
            {{ isset($category) ? 'Edit: ' . $category->name : 'Create New Category' }}
        </h2>

          <form method="POST"
              action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
              enctype="multipart/form-data">
            @csrf
            @if(isset($category)) @method('PUT') @endif

            <div class="space-y-5">

                {{-- Name --}}
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', $category->name ?? '') }}"
                           required
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-100 placeholder-gray-600 focus:outline-none focus:ring-1 focus:ring-brand @error('name') border-red-700 @enderror">
                    @error('name')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>

                {{-- Slug --}}
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">
                        Slug
                        <span class="text-gray-300 font-normal normal-case tracking-normal">(auto-generated if blank)</span>
                    </label>
                    <input type="text" name="slug" id="slug"
                           value="{{ old('slug', $category->slug ?? '') }}"
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-sm font-mono text-gray-400 placeholder-gray-600 focus:outline-none focus:ring-1 focus:ring-brand @error('slug') border-red-700 @enderror">
                    @error('slug')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Description</label>
                    <textarea name="description" rows="3"
                              class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-100 placeholder-gray-600 focus:outline-none focus:ring-1 focus:ring-brand resize-y">{{ old('description', $category->description ?? '') }}</textarea>
                </div>

                {{-- Image upload --}}
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Image</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-100 focus:outline-none focus:ring-1 focus:ring-brand">
                    @if(isset($category) && $category->imageUrl)
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
                        <div class="mt-2">
                            <p class="text-xs text-gray-400">Current:</p>
                            <img src="{{ $catPath }}" alt="Current image" class="h-20 w-20 object-cover rounded border border-gray-700">
                        </div>
                    @endif
                </div>

            </div>

            <div class="mt-8 flex items-center gap-3">
                <button type="submit"
                        class="bg-brand text-gray-50 text-sm font-semibold px-6 py-2.5 rounded-xl hover:bg-brand-dark transition-colors">
                    {{ isset($category) ? 'Update Category' : 'Create Category' }}
                </button>
                <a href="{{ route('admin.categories.index') }}"
                   class="text-sm text-gray-400 hover:text-gray-300 px-4 py-2.5 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-generate slug from name (only if slug not manually edited)
const nameInput = document.getElementById('name');
const slugInput = document.getElementById('slug');
let slugManual  = slugInput.value !== '';   // if editing, slug is already set

function toSlug(str) {
    return str.toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')   // strip accents
        .replace(/[^a-z0-9\s-]/g, '')
        .trim()
        .replace(/[\s_]+/g, '-')
        .replace(/-+/g, '-');
}

nameInput.addEventListener('input', () => {
    if (!slugManual) slugInput.value = toSlug(nameInput.value);
});
slugInput.addEventListener('input', () => {
    slugManual = slugInput.value !== '';
});
</script>
@endpush
