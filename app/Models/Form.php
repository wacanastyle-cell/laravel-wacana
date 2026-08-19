<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Form extends Model
{
    use HasFactory;

    protected $table = 'forms';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
        'starts_at',
        'ends_at',
        'confirmation_message',
        'email_notification_enabled',
        'admin_notification_enabled',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'email_notification_enabled' => 'boolean',
        'admin_notification_enabled' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Form $form) {
            if (empty($form->slug)) {
                $form->slug = Str::slug($form->title);
            }
        });
    }

    public function fields()
    {
        return $this->hasMany(FormField::class)->orderBy('sort_order');
    }

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeIsActive($query)
    {
        return $query->where('status', 'open')
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            });
    }
}