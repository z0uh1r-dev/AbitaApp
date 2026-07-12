<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->is_admin;
    }

    public function rules(): array
    {
        return [
            // Core fields
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['required', 'string'],
            // main image file instead of a URL
            'image'       => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'categoryId'  => ['required', 'integer', 'exists:categories,id'],

            // Specifications
            'specifications'          => ['nullable', 'array'],
            'specifications.*.label'  => ['required_with:specifications.*.value', 'string', 'max:255'],
            'specifications.*.value'  => ['required_with:specifications.*.label', 'string', 'max:500'],

            // Customizations
            'customizations'   => ['nullable', 'array'],
            'customizations.*' => ['required', 'string', 'max:255'],

            // Images
            // gallery images: each row may contain a file upload
            'images'             => ['nullable', 'array'],
            'images.*.file'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'images.*.alt'       => ['nullable', 'string', 'max:255'],
            'images.*.order'     => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($v) {
            $images = $this->input('images', []);
            
            // Filter to only valid rows (those with files)
            $validImages = array_filter($images, fn($img) => !empty($img['file']));
            
            // Ensure image order values are unique within submitted array
            $orders = array_column($validImages, 'order');
            if (count($orders) !== count(array_unique($orders))) {
                $v->errors()->add('images', 'Each image must have a unique order value.');
            }
        });
    }

    protected function prepareForValidation(): void
    {
        if (empty($this->slug)) {
            $this->merge(['slug' => Product::generateUniqueSlug($this->name ?? '')]);
        } else {
            $this->merge(['slug' => Str::slug($this->slug)]);
        }
    }
}
