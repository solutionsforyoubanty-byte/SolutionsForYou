<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'phone', 'address_line1', 'address_line2',
        'city', 'state', 'pincode', 'landmark', 'type', 'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute()
    {
        $parts = [$this->address_line1];
        if ($this->address_line2) $parts[] = $this->address_line2;
        if ($this->landmark) $parts[] = 'Near ' . $this->landmark;
        $parts[] = $this->city . ', ' . $this->state . ' - ' . $this->pincode;
        return implode(', ', $parts);
    }
}
