<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Get all categories for home page.
     */
    public function index()
    {
        return response()->json([
            'data' => Category::select('id', 'name', 'slug', 'description', 'imageUrl')
                ->get(),
        ]);
    }
}
