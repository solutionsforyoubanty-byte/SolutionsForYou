<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 'slug', 'image', 'category', 'excerpt', 'content',
        'author', 'tags', 'views', 'status', 'is_featured', 'published_at',
        'meta_title', 'meta_description', 'meta_keywords'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title')) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('uploads/blogs/' . $this->image) : asset('images/default-blog.jpg');
    }

    public function getTagsArrayAttribute()
    {
        return $this->tags ? explode(',', $this->tags) : [];
    }

    public function getReadTimeAttribute()
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = ceil($words / 200);
        return $minutes . ' min read';
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
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
              ->orWhere('excerpt', 'LIKE', "%{$term}%")
              ->orWhere('content', 'LIKE', "%{$term}%")
              ->orWhere('tags', 'LIKE', "%{$term}%");
        });
    }

    // Increment views
    public function incrementViews()
    {
        $this->increment('views');
    }
}
