<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'image',
        'caption',
        'sort_order',
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->image) : null;
    }
}