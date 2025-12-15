<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceQuestion extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'service_id',
        'question'
    ];

    protected $casts = [
        'service_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
