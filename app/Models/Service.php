<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title','slug','image','short_description','description',
        'meta_title','meta_description','meta_keywords',
        'basic_price','standard_price','premium_price',
        'basic_features','standard_features','premium_features',
        'basic_delivery','standard_delivery','premium_delivery',
        'show_pricing'
    ];

    protected $casts_pricing = [
        'basic_price' => 'decimal:2',
        'standard_price' => 'decimal:2',
        'premium_price' => 'decimal:2',
        'show_pricing' => 'boolean',
    ];

    // Get features as array
    public function getBasicFeaturesArrayAttribute()
    {
        return $this->basic_features ? explode("\n", $this->basic_features) : [];
    }

    public function getStandardFeaturesArrayAttribute()
    {
        return $this->standard_features ? explode("\n", $this->standard_features) : [];
    }

    public function getPremiumFeaturesArrayAttribute()
    {
        return $this->premium_features ? explode("\n", $this->premium_features) : [];
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });

        static::updating(function ($service) {
            if ($service->isDirty('title')) {
                $service->slug = Str::slug($service->title);
            }
        });
    }

    // Relationships
    public function questions()
    {
        return $this->hasMany(ServiceQuestion::class);
    }

    public function inquiries()
    {
        return $this->hasMany(ServiceInquiry::class);
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('uploads/services/' . $this->image) : asset('images/default-service.jpg');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'LIKE', "%{$term}%")
              ->orWhere('short_description', 'LIKE', "%{$term}%")
              ->orWhere('description', 'LIKE', "%{$term}%");
        });
    }
}
