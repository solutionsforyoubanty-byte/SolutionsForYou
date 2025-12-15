<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 'slug', 'image', 'category', 'short_description', 'description',
        'client_name', 'project_url', 'technologies', 'completion_date',
        'status', 'is_featured', 'meta_title', 'meta_description', 'meta_keywords'
    ];

    protected $casts = [
        'completion_date' => 'date',
        'is_featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });

        static::updating(function ($project) {
            if ($project->isDirty('title')) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('uploads/projects/' . $this->image) : asset('images/default-project.jpg');
    }

    public function getTechnologiesArrayAttribute()
    {
        return $this->technologies ? explode(',', $this->technologies) : [];
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'LIKE', "%{$term}%")
              ->orWhere('short_description', 'LIKE', "%{$term}%")
              ->orWhere('technologies', 'LIKE', "%{$term}%");
        });
    }
}
