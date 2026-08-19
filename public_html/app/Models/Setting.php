<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        return static::query()
            ->where('key', $key)
            ->value('value') ?? $default;
    }

    public static function getAll(string $group = null): array
    {
        return Cache::remember('settings' . ($group ? ':' . $group : ''), 3600, function () use ($group) {
            $query = static::query();
            if ($group) {
                $query->where('group', $group);
            }
            return $query->pluck('value', 'key')->toArray();
        });
    }

    public static function set(string $key, mixed $value, string $group = 'general'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
        Cache::forget('settings');
        Cache::forget('settings:' . $group);
    }
}