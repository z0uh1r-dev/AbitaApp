<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('products')
            ->when(request('q'), fn ($q, $search) =>
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['imageUrl'] = $data['image']->store('products', 'public');
            unset($data['image']);
        }
        Category::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category): View
    {
        $category->loadCount('products');
        $products = $category->products()->latest()->paginate(10);

        return view('admin.categories.show', compact('category', 'products'));
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            // delete previous file if present
            if ($category->imageUrl) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($category->imageUrl);
            }
            $data['imageUrl'] = $data['image']->store('products', 'public');
            unset($data['image']);
        }
        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if (! $category->canBeDeleted()) {
            return back()->with('error', 'Cannot delete a category that has products. Reassign or delete them first.');
        }
        // remove stored image if there is one
        if ($category->imageUrl) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($category->imageUrl);
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted.');
    }
}
