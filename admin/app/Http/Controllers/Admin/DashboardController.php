<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Quote;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'categories' => Category::count(),
            'products'   => Product::count(),
            'quotes'     => Quote::count(),
        ];

        $latestQuotes      = Quote::latest('createdAt')->take(5)->get();
        $inProgressQuotes  = Quote::where('status', 'In Progress')->latest('createdAt')->take(10)->get();
        $latestProducts    = Product::with('category')->latest()->take(8)->get();

        return view('admin.dashboard', compact('stats', 'latestQuotes', 'inProgressQuotes', 'latestProducts'));
    }
}
