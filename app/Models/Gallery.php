<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover',
        'event_date',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    protected static function booted(): void
    {
        static::saving(function (Gallery $gallery) {
            if (empty($gallery->slug)) {
                $gallery->slug = Str::slug($gallery->title);
            }
        });
    }

    public function photos()
    {
        return $this->hasMany(GalleryPhoto::class)->orderBy('sort_order');
    }

    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->cover) : null;
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}