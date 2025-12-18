<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'service_id',
        'plan_type',
        'amount',
        'currency',
        'customer_name',
        'customer_email',
        'customer_phone',
        'status',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'notes' => 'array',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'paid' => '<span class="badge bg-success">Paid</span>',
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'failed' => '<span class="badge bg-danger">Failed</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
