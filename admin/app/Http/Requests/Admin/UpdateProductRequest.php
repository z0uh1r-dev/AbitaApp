<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isSuperAdmin();
    }

    public function rules(): array
    {
        $id = $this->route('product')->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', "unique:products,slug,{$id}"],
            'description' => ['required', 'string'],
            // main image may be replaced with new upload, otherwise keep existing
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'categoryId' => ['required', 'integer', 'exists:categories,id'],

            'specifications' => ['nullable', 'array'],
            'specifications.*.label' => ['required_with:specifications.*.value', 'string', 'max:255'],
            'specifications.*.value' => ['required_with:specifications.*.label', 'string', 'max:500'],

            'customizations' => ['nullable', 'array'],
            'customizations.*' => ['required', 'string', 'max:255'],

            'images' => ['nullable', 'array'],
            // either a new file is provided or an existing path is kept
            'images.*.file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'images.*.existing' => ['nullable', 'string', 'max:500'],
            'images.*.alt' => ['nullable', 'string', 'max:255'],
            'images.*.order' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($v) {
            $images = $this->input('images', []);

            // collect only valid rows (those with files or existing paths)
            $validImages = array_filter($images, fn ($img) => ! empty($img['file']) || ! empty($img['existing']));

            $orders = array_column($validImages, 'order');
            if (count($orders) !== count(array_unique($orders))) {
                $v->errors()->add('images', 'Each image must have a unique order value.');
            }

            // ensure every valid row has either a new file or an existing path
            foreach ($validImages as $idx => $img) {
                $hasFile = ! empty($img['file']);
                $hasExisting = ! empty($img['existing']);
                if (! $hasFile && ! $hasExisting) {
                    $v->errors()->add("images.{$idx}", 'Image is required or you must keep the existing file.');
                }
            }
        });
    }

    protected function prepareForValidation(): void
    {
        $product = $this->route('product');

        if (empty($this->slug)) {
            $this->merge(['slug' => Product::generateUniqueSlug($this->name ?? '', $product?->id)]);
        } else {
            $this->merge(['slug' => Str::slug($this->slug)]);
        }
    }
}
