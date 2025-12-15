<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'brand', 'description', 
        'price', 'sale_price', 'quantity', 'image', 'images', 'specifications',
        'is_active', 'is_featured', 'avg_rating', 'reviews_count', 'sold_count'
    ];

    protected $casts = [
        'images' => 'array',
        'specifications' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    public function getIsOnSaleAttribute()
    {
        return $this->sale_price !== null && $this->sale_price < $this->price;
    }

    public function getDiscountPercentAttribute()
    {
        if (!$this->is_on_sale) return 0;
        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    public function isWishlisted()
    {
        if (!auth()->check()) return false;
        return $this->wishlists()->where('user_id', auth()->id())->exists();
    }

    public function getAllImagesAttribute()
    {
        $images = [];
        if ($this->image) $images[] = $this->image;
        if ($this->images) $images = array_merge($images, $this->images);
        return $images;
    }

    public function updateRating()
    {
        $this->avg_rating = $this->reviews()->avg('rating') ?? 0;
        $this->reviews_count = $this->reviews()->count();
        $this->save();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeDeals($query)
    {
        return $query->whereNotNull('sale_price')->where('sale_price', '<', \DB::raw('price'));
    }
}
