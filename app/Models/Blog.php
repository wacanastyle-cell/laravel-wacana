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

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'published_at',
        'scheduled_at',

        'category',
        'tags',
        'featured',

        'show_title',
        'show_excerpt',
        'show_thumbnail',
        'show_author',
        'show_date',
        'show_category',
        'show_tags',
        'show_reading_time',

        'seo_title',
        'meta_description',
        'focus_keyword',
        'canonical_url',

        'og_title',
        'og_description',
        'og_image',

        'views',
        'reading_time',
        'word_count',
        'character_count',

        'autosave',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',

        'show_title' => 'boolean',
        'show_excerpt' => 'boolean',
        'show_thumbnail' => 'boolean',
        'show_author' => 'boolean',
        'show_date' => 'boolean',
        'show_category' => 'boolean',
        'show_tags' => 'boolean',
        'show_reading_time' => 'boolean',

        'featured' => 'boolean',
        'autosave' => 'boolean',

        'views' => 'integer',
        'reading_time' => 'integer',
        'word_count' => 'integer',
        'character_count' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Blog $blog) {
            if (Auth::check()) {
                $blog->user_id = Auth::id();
            }

            self::calculateStatistics($blog);

            if ($blog->status === 'published' && is_null($blog->published_at)) {
                $blog->published_at = now();
            }
        });

        static::updating(function (Blog $blog) {
            self::calculateStatistics($blog);

            if ($blog->status === 'published' && is_null($blog->published_at)) {
                $blog->published_at = now();
            }
        });
    }

    protected static function calculateStatistics(Blog $blog): void
    {
        $html = (string) $blog->content;

        $text = trim(strip_tags($html));

        $blog->word_count = $text === ''
            ? 0
            : str_word_count($text);

        $blog->character_count = mb_strlen($text);

        $blog->reading_time = $blog->word_count > 0
            ? max(1, (int) ceil($blog->word_count / 200))
            : 0;
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
