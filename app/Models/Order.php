<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'user_id', 'address_id', 'subtotal', 'shipping_charge', 
        'tax', 'discount', 'coupon_code', 'total', 'name', 'email', 'phone', 
        'address', 'city', 'state', 'zip_code', 'status', 'payment_status', 
        'payment_method', 'razorpay_order_id', 'razorpay_payment_id', 
        'razorpay_signature', 'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public static function generateOrderNumber()
    {
        return 'ORD-' . strtoupper(uniqid());
    }
}
