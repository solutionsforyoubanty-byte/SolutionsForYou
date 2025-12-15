<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featured_products = Product::active()->featured()
            ->with('category')
            ->take(10)->get();
        
        $categories = Category::where('is_active', true)
            ->withCount('activeProducts')
            ->take(8)->get();
        
        $latest_products = Product::active()
            ->with('category')
            ->latest()
            ->take(10)->get();

        $deals = Product::active()->deals()
            ->with('category')
            ->take(6)->get();

        return view('home', compact('featured_products', 'categories', 'latest_products', 'deals'));
    }
}
