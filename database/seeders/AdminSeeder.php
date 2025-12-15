<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Test User
        User::create([
            'name' => 'Test User',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'description' => 'Mobiles, Laptops, Cameras & more'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'description' => 'Clothing, Footwear & Accessories'],
            ['name' => 'Home & Furniture', 'slug' => 'home-furniture', 'description' => 'Furniture, Decor & Kitchen'],
            ['name' => 'Appliances', 'slug' => 'appliances', 'description' => 'TVs, ACs, Washing Machines'],
            ['name' => 'Beauty', 'slug' => 'beauty', 'description' => 'Makeup, Skincare & Fragrances'],
            ['name' => 'Sports', 'slug' => 'sports', 'description' => 'Sports Equipment & Fitness'],
        ];

        foreach ($categories as $cat) {
            Category::create(array_merge($cat, ['is_active' => true]));
        }

        // Create Sample Products
        $products = [
            ['category_id' => 1, 'name' => 'iPhone 15 Pro Max', 'price' => 159900, 'sale_price' => 149900, 'quantity' => 50, 'is_featured' => true, 'brand' => 'Apple'],
            ['category_id' => 1, 'name' => 'Samsung Galaxy S24 Ultra', 'price' => 134999, 'sale_price' => 124999, 'quantity' => 30, 'is_featured' => true, 'brand' => 'Samsung'],
            ['category_id' => 1, 'name' => 'MacBook Air M3', 'price' => 114900, 'sale_price' => 109900, 'quantity' => 20, 'is_featured' => true, 'brand' => 'Apple'],
            ['category_id' => 1, 'name' => 'Sony WH-1000XM5 Headphones', 'price' => 29990, 'sale_price' => 24990, 'quantity' => 100, 'brand' => 'Sony'],
            ['category_id' => 2, 'name' => 'Nike Air Max 270', 'price' => 12995, 'sale_price' => 8999, 'quantity' => 200, 'is_featured' => true, 'brand' => 'Nike'],
            ['category_id' => 2, 'name' => 'Levis 501 Original Jeans', 'price' => 4999, 'sale_price' => 3499, 'quantity' => 150, 'brand' => 'Levis'],
            ['category_id' => 3, 'name' => 'Wooden Study Table', 'price' => 8999, 'sale_price' => 6999, 'quantity' => 40, 'brand' => 'HomeTown'],
            ['category_id' => 3, 'name' => 'Memory Foam Mattress', 'price' => 24999, 'sale_price' => 19999, 'quantity' => 25, 'is_featured' => true, 'brand' => 'Sleepwell'],
            ['category_id' => 4, 'name' => 'LG 55" 4K Smart TV', 'price' => 54999, 'sale_price' => 44999, 'quantity' => 15, 'is_featured' => true, 'brand' => 'LG'],
            ['category_id' => 4, 'name' => 'Samsung 1.5 Ton Split AC', 'price' => 45999, 'sale_price' => 38999, 'quantity' => 20, 'brand' => 'Samsung'],
            ['category_id' => 5, 'name' => 'Maybelline Makeup Kit', 'price' => 2999, 'sale_price' => 1999, 'quantity' => 300, 'brand' => 'Maybelline'],
            ['category_id' => 6, 'name' => 'Fitness Dumbbell Set', 'price' => 4999, 'sale_price' => 3499, 'quantity' => 80, 'brand' => 'Decathlon'],
        ];

        foreach ($products as $prod) {
            Product::create(array_merge($prod, [
                'slug' => Str::slug($prod['name']) . '-' . uniqid(),
                'description' => 'High quality ' . $prod['name'] . ' with amazing features and great value for money.',
                'is_active' => true,
                'avg_rating' => rand(35, 50) / 10,
                'reviews_count' => rand(10, 500),
            ]));
        }

        // Create Sample Coupons
        Coupon::create([
            'code' => 'WELCOME10',
            'type' => 'percent',
            'value' => 10,
            'min_order' => 500,
            'max_discount' => 200,
            'valid_from' => now(),
            'valid_until' => now()->addMonths(3),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'FLAT100',
            'type' => 'fixed',
            'value' => 100,
            'min_order' => 999,
            'valid_from' => now(),
            'valid_until' => now()->addMonths(1),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'SUPER20',
            'type' => 'percent',
            'value' => 20,
            'min_order' => 2000,
            'max_discount' => 500,
            'valid_from' => now(),
            'valid_until' => now()->addMonths(2),
            'is_active' => true,
        ]);

        // Default Settings
        \App\Models\Setting::set('cod_enabled', '1');
        \App\Models\Setting::set('cod_min_order', '0');
        \App\Models\Setting::set('cod_max_order', '');
        \App\Models\Setting::set('free_shipping_min', '499');
        \App\Models\Setting::set('shipping_charge', '40');
        \App\Models\Setting::set('tax_percent', '18');
    }
}
