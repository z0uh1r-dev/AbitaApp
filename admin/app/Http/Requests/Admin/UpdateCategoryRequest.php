<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->is_admin;
    }

    public function rules(): array
    {
        $id = $this->route('category')->id;

        return [
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', "unique:categories,slug,{$id}"],
            'description' => ['nullable', 'string'],
            // may replace existing image with new upload
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $category = $this->route('category');

        if (empty($this->slug)) {
            $this->merge([
                'slug' => Category::generateUniqueSlug($this->name ?? '', $category?->id),
            ]);
        } else {
            $this->merge(['slug' => Str::slug($this->slug)]);
        }
    }
}
