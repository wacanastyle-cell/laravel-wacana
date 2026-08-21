<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Blog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'published_at',
        'show_title',
        'show_excerpt',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
        'show_title' => 'boolean',
        'show_excerpt' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Blog $blog) {
            if (Auth::check()) {
                $blog->user_id = Auth::id();
            }

            if ($blog->status === 'published' && is_null($blog->published_at)) {
                $blog->published_at = now();
            }
        });

        static::updating(function (Blog $blog) {
            if ($blog->status === 'published' && is_null($blog->published_at)) {
                $blog->published_at = now();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeRecent(Builder $query): void
    {
        $query->orderBy('published_at', 'desc');
    }
}