<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with('category');

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Price filter
        if ($request->min_price) {
            $query->where(function($q) use ($request) {
                $q->where('sale_price', '>=', $request->min_price)
                  ->orWhere(function($q2) use ($request) {
                      $q2->whereNull('sale_price')->where('price', '>=', $request->min_price);
                  });
            });
        }
        if ($request->max_price) {
            $query->where(function($q) use ($request) {
                $q->where('sale_price', '<=', $request->max_price)
                  ->orWhere(function($q2) use ($request) {
                      $q2->whereNull('sale_price')->where('price', '<=', $request->max_price);
                  });
            });
        }

        // Rating filter
        if ($request->rating) {
            $query->where('avg_rating', '>=', $request->rating);
        }

        // In stock filter
        if ($request->in_stock) {
            $query->where('quantity', '>', 0);
        }

        // Featured filter
        if ($request->featured) {
            $query->featured();
        }

        // Deals filter
        if ($request->deals) {
            $query->deals();
        }

        // Sorting
        switch ($request->sort) {
            case 'price_low':
                $query->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'rating':
                $query->orderBy('avg_rating', 'desc');
                break;
            case 'popularity':
                $query->orderBy('sold_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('shop.index', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->active()->with(['category', 'reviews.user'])->firstOrFail();
        
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->take(5)->get();

        return view('shop.show', compact('product', 'related'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        $query = $category->activeProducts()->with('category');

        // Apply same filters as index
        $request = request();
        
        if ($request->min_price) {
            $query->where(function($q) use ($request) {
                $q->where('sale_price', '>=', $request->min_price)
                  ->orWhere(function($q2) use ($request) {
                      $q2->whereNull('sale_price')->where('price', '>=', $request->min_price);
                  });
            });
        }
        if ($request->max_price) {
            $query->where(function($q) use ($request) {
                $q->where('sale_price', '<=', $request->max_price)
                  ->orWhere(function($q2) use ($request) {
                      $q2->whereNull('sale_price')->where('price', '<=', $request->max_price);
                  });
            });
        }
        if ($request->rating) {
            $query->where('avg_rating', '>=', $request->rating);
        }
        if ($request->in_stock) {
            $query->where('quantity', '>', 0);
        }

        switch ($request->sort) {
            case 'price_low':
                $query->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'rating':
                $query->orderBy('avg_rating', 'desc');
                break;
            case 'popularity':
                $query->orderBy('sold_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('shop.index', compact('products', 'categories', 'category'));
    }
}
