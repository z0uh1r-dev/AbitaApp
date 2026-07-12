<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Get all products.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Product::query()
                ->select('id', 'name', 'slug', 'description', 'imageUrl', 'categoryId')
                ->get(),
        ]);
    }

    /**
     * Get products by category slug.
     */
    public function byCategory(string $categorySlug): JsonResponse
    {
        $category = Category::where('slug', $categorySlug)
            ->firstOrFail();

        return response()->json([
            'data' => $category->products()
                ->select('id', 'name', 'slug', 'description', 'imageUrl', 'categoryId')
                ->get(),
        ]);
    }

    /**
     * Get product by slug with 3 random related products.
     */
    public function show(string $productSlug): JsonResponse
    {
        $product = Product::where('slug', $productSlug)
            ->with('specifications', 'customizations', 'images', 'category')
            ->firstOrFail();

        $relatedProducts = Product::where('categoryId', $product->categoryId)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(3)
            ->select('id', 'name', 'slug', 'description', 'imageUrl', 'categoryId')
            ->get();

        return response()->json([
            'data' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
