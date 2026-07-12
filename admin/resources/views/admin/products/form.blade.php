@extends('layouts.admin')
@section('title', isset($product) ? 'Edit: ' . $product->name : 'New Product')

@section('header-actions')
    @isset($product)
        <a href="{{ route('admin.products.show', $product) }}"
           class="text-sm text-gray-400 hover:text-gray-300 px-4 py-2 transition-colors">View →</a>
    @endisset
    <a href="{{ route('admin.products.index') }}"
       class="inline-flex items-center gap-2 bg-gray-800 border border-gray-700 text-gray-300 text-sm font-medium px-4 py-2 rounded-xl hover:bg-gray-700 transition-colors">
        ← Back
    </a>
@endsection

@push('styles')
<style>
.section-heading {
    display: flex; align-items: center; gap: 12px;
    font-family: 'Syne', sans-serif; font-weight: 700; font-size: 11px;
    text-transform: uppercase; letter-spacing: .1em; color: #00A1E0;
    margin-bottom: 16px; margin-top: 32px;
}
.section-heading::after { content: ''; flex: 1; height: 1px; background: #1f2937; }
.row-card {
    display: grid; gap: 10px; align-items: end;
    background: #111827; border: 1px solid #1f2937; border-radius: 12px;
    padding: 14px; margin-bottom: 8px; position: relative;
}
.row-specs   { grid-template-columns: 1fr 1fr auto; }
.row-customs { grid-template-columns: 1fr auto; }
.row-images  { grid-template-columns: 2fr 1fr 80px auto; }
.field-label {
    display: block; font-size: 10px; font-weight: 600;
    text-transform: uppercase; letter-spacing: .08em; color: #6b7280; margin-bottom: 6px;
}
.field-input {
    width: 100%; background: #1f2937; border: 1px solid #374151;
    border-radius: 8px; padding: 8px 12px; font-size: 13px; color: #e5e7eb;
    font-family: 'DM Sans', sans-serif; transition: border-color .15s;
}
.field-input:focus { outline: none; border-color: #00A1E0; }
.remove-row {
    display: inline-flex; align-items: center; justify-content: center;
    background: #1a0a0a; color: #f87171; border: 1px solid #3f1515;
    border-radius: 8px; padding: 8px 12px; cursor: pointer; font-size: 12px;
    transition: all .15s; white-space: nowrap; align-self: end;
}
.remove-row:hover { background: #3f1515; }
.add-row-btn {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(0,161,224,.1); color: #00A1E0;
    border: 1px dashed rgba(0,161,224,.3); border-radius: 10px;
    padding: 8px 16px; cursor: pointer; font-size: 12px;
    font-family: 'DM Sans', sans-serif; font-weight: 500;
    transition: all .15s;
}
.add-row-btn:hover { background: rgba(0,161,224,.2); }

/* gallery-specific helpers */
.drag-handle {
    cursor: grab;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    padding: 4px;
}
.drag-handle:hover { color: #00A1E0; }

.gallery-input {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.sortable-empty {
    min-height: 60px;
    border: 2px dashed #d1d5db;
    border-radius: 10px;
}

/* modal used for image preview */
.preview-modal {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.85);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: opacity .2s;
    z-index: 999;
}
.preview-modal.show { opacity: 1; visibility: visible; }
.preview-modal img { max-width: 90%; max-height: 90%; border-radius: 12px; }

/* dropzone area for bulk uploads */
.dropzone {
    position: relative;
    background: #1f2937;
    border: 2px dashed #374151;
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    color: #9ca3af;
    cursor: pointer;
}
.dropzone:hover { background: #111827; }
</style>
@endpush

@section('content')

@if($errors->any())
<div class="mb-6 bg-red-950 border border-red-800 rounded-xl p-4">
    <ul class="text-sm text-red-400 space-y-1 list-disc list-inside">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
</div>
@endif

<form method="POST"
    action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
    id="product-form" enctype="multipart/form-data">
    @csrf
    @if(isset($product)) @method('PUT') @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- ── LEFT COLUMN: core info ──────────────────────────────────── --}}
        <div class="xl:col-span-2 space-y-6">

            {{-- Basic Info --}}
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
                <h3 class="font-display font-bold text-sm mb-5">Product Information</h3>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                   value="{{ old('name', $product->name ?? '') }}" required
                                   class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-100 focus:outline-none focus:ring-1 focus:ring-brand @error('name') border-red-700 @enderror">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">
                                Slug <span class="text-gray-300 font-normal normal-case">(auto-generated)</span>
                            </label>
                            <input type="text" name="slug" id="slug"
                                   value="{{ old('slug', $product->slug ?? '') }}"
                                   class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-sm font-mono text-gray-400 focus:outline-none focus:ring-1 focus:ring-brand @error('slug') border-red-700 @enderror">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" rows="4" required
                                  class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-100 focus:outline-none focus:ring-1 focus:ring-brand resize-y @error('description') border-red-700 @enderror">{{ old('description', $product->description ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">
                            Main Image {{ !isset($product) || !$product->imageUrl ? '<span class="text-red-500">*</span>' : '' }}
                        </label>
                        <input type="file" name="image" accept="image/*" {{ !isset($product) || !$product->imageUrl ? 'required' : '' }}
                               class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-100 focus:outline-none focus:ring-1 focus:ring-brand @error('image') border-red-700 @enderror">
                        @if(isset($product) && $product->imageUrl)
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
                            <div class="mt-2">
                                <p class="text-xs text-gray-400">Current:</p>
                                <img src="{{ $mainPath }}" alt="Current image" class="h-20 w-20 object-cover rounded border border-gray-700">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ── SPECIFICATIONS ──────────────────────────────────────── --}}
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
                <div class="section-heading">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Specifications
                </div>

                <div id="specs-container">
                    @php
                        $specs = old('specifications',
                            isset($product)
                                ? $product->specifications->map(fn($s)=>['label'=>$s->label,'value'=>$s->value])->toArray()
                                : []
                        );
                    @endphp
                    @foreach($specs as $i => $spec)
                    <div class="row-card row-specs">
                        <div>
                            <label class="field-label">Label</label>
                            <input type="text" name="specifications[{{ $i }}][label]"
                                   value="{{ $spec['label'] }}" placeholder="e.g. Material"
                                   class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Value</label>
                            <input type="text" name="specifications[{{ $i }}][value]"
                                   value="{{ $spec['value'] }}" placeholder="e.g. Aluminium"
                                   class="field-input">
                        </div>
                        <button type="button" class="remove-row" onclick="removeRow(this)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="add-row-btn mt-2" onclick="addSpec()">
                    + Add Specification
                </button>
            </div>

            {{-- ── CUSTOMIZATIONS ──────────────────────────────────────── --}}
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
                <div class="section-heading">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    Customization Options
                </div>

                <div id="customs-container">
                    @php
                        $customs = old('customizations',
                            isset($product)
                                ? $product->customizations->pluck('label')->toArray()
                                : []
                        );
                    @endphp
                    @foreach($customs as $i => $label)
                    <div class="row-card row-customs">
                        <div>
                            <label class="field-label">Option Label</label>
                            <input type="text" name="customizations[{{ $i }}]"
                                   value="{{ $label }}" placeholder="e.g. Logo embossing"
                                   class="field-input">
                        </div>
                        <button type="button" class="remove-row" onclick="removeRow(this)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="add-row-btn mt-2" onclick="addCustom()">
                    + Add Option
                </button>
            </div>

            {{-- ── GALLERY IMAGES ──────────────────────────────────────── --}}
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
                <div class="section-heading">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Gallery Images
                    <span style="color:#6b7280;font-size:10px;font-weight:400;text-transform:none;letter-spacing:0">Order must be unique per product</span>
                </div>
                {{-- bulk upload area --}}
                <div id="gallery-dropzone" class="dropzone mb-4">
                    Drop images here or click to upload
                    <input type="file" accept="image/*" multiple class="gallery-input"
                           onchange="handleBulkUpload(this.files)">
                </div>

                @php
                    // prepare images array up front so count() is safe
                    $images = old('images',
                        isset($product)
                            ? $product->images->map(function($img) {
                                // normalize URL - remove any leading /images/ prefix
                                $url = $img->url;
                                if (str_starts_with($url, '/images/products/')) {
                                    $url = str_replace('/images/products/', 'products/', $url);
                                }
                                return ['existing'=>$url,'alt'=>$img->alt,'order'=>$img->order];
                            })->toArray()
                            : []
                    );
                    if (! is_array($images)) {
                        $images = [];
                    }
                @endphp
                <div id="images-container" class="{{ count($images) ? '' : 'sortable-empty' }}">
                        @foreach($images ?? [] as $i => $img)
                    <div class="row-card row-images sortable-item" data-index="{{ $i }}">
                        <span class="drag-handle" title="Drag to reorder">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                        </span>
                        <div class="relative">
                            <label class="field-label">Image File</label>
                            <div class="relative bg-gray-800 border border-gray-700 rounded-xl overflow-hidden h-24">
                                <input type="file" name="images[{{ $i }}][file]" accept="image/*" class="gallery-input" onchange="handleGalleryFile(this)">
                                @php
                                    $displayUrl = $img['existing'];
                                    if (str_starts_with($displayUrl, '/images/products/')) {
                                        $displayUrl = str_replace('/images/products/', 'products/', $displayUrl);
                                    }
                                    $displayUrl = preg_match('/^https?:\/\//', $displayUrl) ? $displayUrl : Storage::url($displayUrl);
                                @endphp
                                <img src="{{ $displayUrl }}" class="h-full w-full object-cover preview-thumb" onclick="openPreview(this)">
                            </div>
                            <input type="hidden" name="images[{{ $i }}][existing]" value="{{ $img['existing'] }}">
                        </div>
                        <div>
                            <label class="field-label">Alt text</label>
                            <input type="text" name="images[{{ $i }}][alt]"
                                   value="{{ $img['alt'] ?? '' }}" placeholder="Descriptive text"
                                   class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Order</label>
                            <input type="number" name="images[{{ $i }}][order]"
                                   value="{{ $img['order'] }}" min="1" class="field-input order-input">
                        </div>
                        <button type="button" class="remove-row" onclick="removeRow(this)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="add-row-btn mt-2" onclick="addImage()">
                    + Add Image
                </button>
            </div>

        </div>

        {{-- ── RIGHT COLUMN: category + submit ─────────────────────────── --}}
        <div class="xl:col-span-1 space-y-4">

            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
                <h3 class="font-display font-bold text-sm mb-4">Publish</h3>
                <button type="submit"
                        class="w-full bg-brand text-gray-50 text-sm font-bold py-3 rounded-xl hover:bg-brand-dark transition-colors">
                    {{ isset($product) ? '✓ Save Changes' : '✓ Create Product' }}
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="block text-center text-sm text-gray-400 hover:text-gray-300 mt-3 py-2 transition-colors">
                    Cancel
                </a>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-3">
                    Category <span class="text-red-500">*</span>
                </label>
                <select name="categoryId" required
                        class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-100 focus:outline-none focus:ring-1 focus:ring-brand @error('categoryId') border-red-700 @enderror">
                    <option value="">Select a category…</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('categoryId', $product->categoryId ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('categoryId')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            @isset($product)
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 text-xs text-gray-400 space-y-1.5">
                <div>ID: #{{ $product->id }}</div>
                <div>Created: {{ $product->created_at->format('d M Y, H:i') }}</div>
                <div>Updated: {{ $product->updated_at->format('d M Y, H:i') }}</div>
                <div class="pt-2 border-t border-gray-800">
                    <div class="flex gap-2 flex-wrap">
                        <span class="bg-gray-800 px-2 py-0.5 rounded">{{ $product->specifications->count() }} specs</span>
                        <span class="bg-gray-800 px-2 py-0.5 rounded">{{ $product->customizations->count() }} options</span>
                        <span class="bg-gray-800 px-2 py-0.5 rounded">{{ $product->images->count() }} images</span>
                    </div>
                </div>
            </div>
            @endisset
        </div>

    </div>{{-- /grid --}}
</form>
@endsection
{{-- image preview modal --}}
<div id="image-preview-modal" class="preview-modal" onclick="closePreview()">
    <img src="" alt="Preview">
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
// ── Counter for array index continuity ──
let specIdx   = {{ count($specs ?? []) }};
let customIdx = {{ count($customs ?? []) }};
let imageIdx  = {{ count($images ?? []) }};

// ── Slug auto-generation ──
const nameInput = document.getElementById('name');
const slugInput = document.getElementById('slug');
let slugManual  = slugInput.value !== '';

function toSlug(s) {
    return s.toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-z0-9\s-]/g, '').trim().replace(/[\s_]+/g, '-').replace(/-+/g, '-');
}
nameInput.addEventListener('input', () => { if (!slugManual) slugInput.value = toSlug(nameInput.value); });
slugInput.addEventListener('input', () => { slugManual = slugInput.value !== ''; });

// ── Remove a row ──
function removeRow(btn) { btn.closest('.row-card').remove(); }

// ── Add Specification row ──
function addSpec() {
    const i = specIdx++;
    document.getElementById('specs-container').insertAdjacentHTML('beforeend', `
        <div class="row-card row-specs">
            <div>
                <label class="field-label">Label</label>
                <input type="text" name="specifications[${i}][label]" placeholder="e.g. Material" class="field-input">
            </div>
            <div>
                <label class="field-label">Value</label>
                <input type="text" name="specifications[${i}][value]" placeholder="e.g. Aluminium" class="field-input">
            </div>
            <button type="button" class="remove-row" onclick="removeRow(this)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>`);
}

// ── Add Customization row ──
function addCustom() {
    const i = customIdx++;
    document.getElementById('customs-container').insertAdjacentHTML('beforeend', `
        <div class="row-card row-customs">
            <div>
                <label class="field-label">Option Label</label>
                <input type="text" name="customizations[${i}]" placeholder="e.g. Logo embossing" class="field-input">
            </div>
            <button type="button" class="remove-row" onclick="removeRow(this)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>`);
}

// ── Add Image row (can accept File or existing URL for preview) ──
function addImage(file = null, existingUrl = null, alt = '', order = null) {
    const i = imageIdx++;
    const container = document.getElementById('images-container');
    const existingOrders = [...container.querySelectorAll('.order-input')]
        .map(el => parseInt(el.value) || 0);
    const nextOrder = existingOrders.length ? Math.max(...existingOrders) + 1 : 1;
    const rowOrder = order || nextOrder;

    container.insertAdjacentHTML('beforeend', `
        <div class="row-card row-images sortable-item" data-index="${i}">
            <span class="drag-handle" title="Drag to reorder">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
            </span>
            <div class="relative">
                <label class="field-label">Image File</label>
                <div class="relative bg-gray-800 border border-gray-700 rounded-xl overflow-hidden h-24">
                    <input type="file" name="images[${i}][file]" accept="image/*" class="gallery-input" onchange="handleGalleryFile(this)">
                    ${existingUrl ? `<img src="${existingUrl}" class="h-full w-full object-cover preview-thumb" onclick="openPreview(this)">` : ''}
                </div>
                <input type="hidden" name="images[${i}][existing]" value="${existingUrl || ''}">
            </div>
            <div>
                <label class="field-label">Alt text</label>
                <input type="text" name="images[${i}][alt]" value="${alt}" class="field-input">
            </div>
            <div>
                <label class="field-label">Order</label>
                <input type="number" name="images[${i}][order]" value="${rowOrder}" min="1" class="field-input order-input">
            </div>
            <button type="button" class="remove-row" onclick="removeRow(this)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>`);

    // if we were given a File object, attach it and preview
    if (file instanceof File) {
        const row = container.lastElementChild;
        const input = row.querySelector('input[type="file"]');
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
        handleGalleryFile(input);
    }

    // remove empty class once we add a row
    container.classList.remove('sortable-empty');
}

// ── Handle single file selection and show preview ──
function handleGalleryFile(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const container = input.closest('.relative');
        let img = container.querySelector('img.preview-thumb');
        if (!img) {
            img = document.createElement('img');
            img.className = 'h-full w-full object-cover preview-thumb';
            img.setAttribute('onclick', 'openPreview(this)');
            container.appendChild(img);
        }
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

// ── Bulk upload handler ──
function handleBulkUpload(files) {
    Array.from(files).forEach(file => {
        addImage(file);
    });
}

// ── Preview modal controls ──
function openPreview(img) {
    const modal = document.getElementById('image-preview-modal');
    modal.querySelector('img').src = img.src;
    modal.classList.add('show');
}
function closePreview() {
    const modal = document.getElementById('image-preview-modal');
    modal.classList.remove('show');
}

// ── Initialize Sortable for gallery
document.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('images-container');
    if (el) {
        new Sortable(el, {
            handle: '.drag-handle',
            animation: 150,
            onEnd() {
                [...el.querySelectorAll('.order-input')].forEach((input, idx) => input.value = idx + 1);
            }
        });
    }
});

// ── Client-side duplicate order check before submit ──
document.getElementById('product-form').addEventListener('submit', function(e) {
    const orders = [...document.querySelectorAll('#images-container .order-input')]
        .map(el => el.value).filter(Boolean);
    if (new Set(orders).size !== orders.length) {
        e.preventDefault();
        alert('Each gallery image must have a unique order value. Please fix duplicates before saving.');
    }
});
</script>
@endpush
