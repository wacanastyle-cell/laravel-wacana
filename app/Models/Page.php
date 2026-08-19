<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'status',
    ];

    protected static function booted(): void
    {
        static::saving(function (Page $page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->featured_image) : null;
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}