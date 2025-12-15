<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = auth()->user()->wishlists()->with('product.category')->latest()->paginate(12);
        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'removed', 'message' => 'Removed from wishlist']);
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id
        ]);

        return response()->json(['status' => 'added', 'message' => 'Added to wishlist']);
    }

    public function moveToCart(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        $cart = auth()->user()->carts()->where('product_id', $wishlist->product_id)->first();
        
        if ($cart) {
            $cart->increment('quantity');
        } else {
            auth()->user()->carts()->create(['product_id' => $wishlist->product_id, 'quantity' => 1]);
        }

        $wishlist->delete();
        return back()->with('success', 'Moved to cart!');
    }
}
