<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_number',
        'name',
        'slug',
        'photo',
        'motor_type',
        'motor_year',
        'city',
        'whatsapp',
        'instagram',
        'bio',
        'status',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'date',
    ];

    protected static function booted(): void
    {
        static::saving(function (Member $member) {
            if (empty($member->slug)) {
                $member->slug = Str::slug($member->name);
            }
        });
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->photo) : null;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}