<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'type', 'value', 'min_order', 'max_discount',
        'usage_limit', 'used_count', 'valid_from', 'valid_until', 'is_active'
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
    ];

    public function isValid($orderTotal = 0)
    {
        if (!$this->is_active) return false;
        if ($this->valid_from > now()) return false;
        if ($this->valid_until < now()) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        if ($orderTotal < $this->min_order) return false;
        return true;
    }

    public function calculateDiscount($orderTotal)
    {
        if (!$this->isValid($orderTotal)) return 0;

        if ($this->type === 'fixed') {
            return min($this->value, $orderTotal);
        }

        $discount = ($orderTotal * $this->value) / 100;
        if ($this->max_discount) {
            $discount = min($discount, $this->max_discount);
        }
        return $discount;
    }
}
