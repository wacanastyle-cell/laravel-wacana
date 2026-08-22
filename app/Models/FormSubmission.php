<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

        'registration_status',

        'payment_status',
        'payment_amount',
        'payment_method',
        'payment_proof',
        'payment_verified_at',
        'payment_notes',

        'admin_notes',

        'submitted_at',
    ];

    protected $casts = [
        'data' => 'array',

        'submitted_at' => 'datetime',

        'payment_verified_at' => 'datetime',

        'payment_amount' => 'float',
    ];

    public const REGISTRATION_STATUSES = [
        'pending' => 'Menunggu',
        'accepted' => 'Diterima',
        'rejected' => 'Ditolak',
        'cancelled' => 'Dibatalkan',
    ];

    public const PAYMENT_STATUSES = [
        'unpaid' => 'Belum Bayar',
        'verification' => 'Menunggu Verifikasi',
        'paid' => 'Lunas',
        'rejected' => 'Ditolak',
        'refunded' => 'Refund',
    ];

    protected static function booted(): void
    {
        static::creating(function (FormSubmission $submission) {

            if (empty($submission->reference_number)) {
                $submission->reference_number =
                    self::generateReferenceNumber();
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

        $last = self::where(
            'reference_number',
            'like',
            $prefix . '%'
        )
            ->orderBy('id', 'desc')
            ->value('reference_number');

        $nextNumber = 1;

        if ($last) {
            $parts = explode('-', $last);

            $nextNumber =
                (int) end($parts) + 1;
        }

        return $prefix .
            str_pad(
                $nextNumber,
                6,
                '0',
                STR_PAD_LEFT
            );
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function scopeByRegistrationStatus(
        $query,
        string $status
    ) {
        return $query->where(
            'registration_status',
            $status
        );
    }

    public function scopeByPaymentStatus(
        $query,
        string $status
    ) {
        return $query->where(
            'payment_status',
            $status
        );
    }

    public function paymentProofUrl(): ?string
    {
        $path = $this->payment_proof;

        if (
            !$path &&
            is_array($this->data)
        ) {
            $path =
                $this->data['bukti_pembayaran']
                ?? null;
        }

        if (!$path || is_array($path)) {
            return null;
        }

        if (
            str_starts_with($path, 'http://') ||
            str_starts_with($path, 'https://')
        ) {
            return $path;
        }

        return Storage::disk('public')
            ->url($path);
    }

    public function whatsappUrl(): ?string
    {
        if (!$this->submitter_phone) {
            return null;
        }

        $number = preg_replace(
            '/[^0-9]/',
            '',
            $this->submitter_phone
        );

        if (str_starts_with($number, '0')) {
            $number =
                '62' . substr($number, 1);
        }

        $message = rawurlencode(
            'Halo ' .
            ($this->submitter_name ?: '') .
            ', terkait pendaftaran ' .
            ($this->form?->title ?: 'Wacana Style') .
            ' dengan nomor ' .
            $this->reference_number .
            '.'
        );

        return
            'https://wa.me/' .
            $number .
            '?text=' .
            $message;
    }
}
