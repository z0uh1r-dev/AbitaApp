<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->is_admin;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:categories,slug'],
            'description' => ['nullable', 'string'],
            // optional image upload instead of manual URL
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ];
    }

    /**
     * Auto-generate slug from name before validation if not supplied.
     */
    protected function prepareForValidation(): void
    {
        if (empty($this->slug)) {
            $this->merge([
                'slug' => Category::generateUniqueSlug($this->name ?? ''),
            ]);
        } else {
            $this->merge(['slug' => Str::slug($this->slug)]);
        }
    }
}
