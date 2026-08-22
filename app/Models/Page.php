<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',

        'published_at',
        'scheduled_at',

        'template',
        'parent_id',
        'menu_order',
        'comments_enabled',

        'seo_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'seo_index',
        'og_image',

        'custom_css_class',
        'custom_fields',

        'show_title',
        'show_excerpt',
        'show_featured_image',
        'show_breadcrumb',
        'show_header',
        'show_footer',
        'show_sidebar',
        'show_published_date',
        'show_author',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',

        'menu_order' => 'integer',

        'comments_enabled' => 'boolean',
        'seo_index' => 'boolean',

        'show_title' => 'boolean',
        'show_excerpt' => 'boolean',
        'show_featured_image' => 'boolean',
        'show_breadcrumb' => 'boolean',
        'show_header' => 'boolean',
        'show_footer' => 'boolean',
        'show_sidebar' => 'boolean',
        'show_published_date' => 'boolean',
        'show_author' => 'boolean',

        'custom_fields' => 'array',
    ];

    protected $appends = [
        'featured_image_url',
        'og_image_url',
    ];

    protected static function booted(): void
    {
        static::saving(function (Page $page) {

            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }

            if (
                $page->status === 'published' &&
                is_null($page->published_at)
            ) {
                $page->published_at = now();
            }
        });
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Page::class, 'parent_id')
            ->orderBy('menu_order');
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image
            ? Storage::disk('public')->url($this->featured_image)
            : null;
    }

    public function getOgImageUrlAttribute(): ?string
    {
        return $this->og_image
            ? Storage::disk('public')->url($this->og_image)
            : null;
    }

    public function scopePublished(Builder $query): void
    {
        $query
            ->where('status', 'published')
            ->where(function (Builder $query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }
}
