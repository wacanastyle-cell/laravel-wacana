<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'cover',
        'event_date',
        'status',
        'featured',

        'event_name',
        'location',
        'city',
        'organizer',
        'event_description',

        'show_title',
        'show_description',
        'show_date',
        'show_location',
        'show_category',
        'show_video',

        'seo_title',
        'meta_description',
        'seo_image',
        'canonical_url',

        'published_at',
        'scheduled_at',
    ];

    protected $casts = [
        'event_date' => 'date',

        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',

        'featured' => 'boolean',

        'show_title' => 'boolean',
        'show_description' => 'boolean',
        'show_date' => 'boolean',
        'show_location' => 'boolean',
        'show_category' => 'boolean',
        'show_video' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Gallery $gallery) {
            if (empty($gallery->slug)) {
                $gallery->slug = Str::slug($gallery->title);
            }

            if (
                $gallery->status === 'published' &&
                is_null($gallery->published_at)
            ) {
                $gallery->published_at = now();
            }
        });
    }

    public function photos()
    {
        return $this->hasMany(GalleryPhoto::class)
            ->orderBy('sort_order');
    }

    public function videos()
    {
        return $this->hasMany(GalleryVideo::class)
            ->orderBy('sort_order');
    }

    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover
            ? Storage::disk('public')->url($this->cover)
            : null;
    }

    public function scopePublished(Builder $query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured(Builder $query)
    {
        return $query->where('featured', true);
    }
}
