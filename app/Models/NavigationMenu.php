<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NavigationMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'slug',
        'href',
        'type',
        'sort_order',
        'is_active',
        'parent_id',
        'icon',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (NavigationMenu $menu) {
            if (empty($menu->slug)) {
                $menu->slug = Str::slug($menu->label);
            }
        });
    }

    /**
     * Get top-level menus only
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Get active menus only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get child menus
     */
    public function children()
    {
        return $this->hasMany(NavigationMenu::class, 'parent_id', 'id')->orderBy('sort_order');
    }

    /**
     * Get parent menu
     */
    public function parent()
    {
        return $this->belongsTo(NavigationMenu::class, 'parent_id');
    }
}
