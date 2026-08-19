<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'reference_number',
        'submitter_name',
        'submitter_email',
        'submitter_phone',
        'data',
        'status',
        'submitted_at',
    ];

    protected $casts = [
        'data' => 'array',
        'submitted_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (FormSubmission $submission) {
            if (empty($submission->reference_number)) {
                $submission->reference_number = self::generateReferenceNumber();
            }
            if (empty($submission->submitted_at)) {
                $submission->submitted_at = now();
            }
        });
    }

    public static function generateReferenceNumber(): string
    {
        $year = now()->format('Y');
        $prefix = 'WS-' . $year . '-';

        $last = self::where('reference_number', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->value('reference_number');

        $nextNumber = 1;
        if ($last) {
            $parts = explode('-', $last);
            $nextNumber = (int)end($parts) + 1;
        }

        return $prefix . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}