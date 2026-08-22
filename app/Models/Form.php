<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Form extends Model
{
    use HasFactory;

    protected $table = 'forms';

    protected $fillable = [

        'thumbnail',
        'banner',

        'category',
        'title',
        'slug',
        'description',
        'status',

        'event_date',
        'event_time',
        'location',
        'google_maps_url',

        'starts_at',
        'ends_at',

        'registration_start',
        'registration_end',

        'quota',

        'payment_enabled',
        'payment_amount',
        'promo_price',
        'payment_methods',
        'payment_deadline',
        'payment_instructions',

        'bank_name',
        'bank_account_number',
        'bank_account_name',

        'ewallet_name',
        'ewallet_number',

        'qris_image',
        'payment_proof_required',

        'price_variations',

        'show_title',
        'show_description',
        'show_banner',
        'show_date',
        'show_time',
        'show_location',
        'show_price',
        'show_quota',
        'show_remaining_quota',
        'show_registration_count',

        'submit_button_text',

        'confirmation_message',
        'success_title',
        'success_message',
        'next_instructions',

        'show_payment_after_submit',

        'redirect_url',

        'open_whatsapp_after_submit',
        'whatsapp_number',
        'whatsapp_message',

        'email_notification_enabled',
        'admin_notification_enabled',

        'published_at',
    ];


    protected $casts = [

        'event_date' => 'date',

        'starts_at' => 'datetime',
        'ends_at' => 'datetime',

        'registration_start' => 'datetime',
        'registration_end' => 'datetime',

        'payment_deadline' => 'datetime',
        'published_at' => 'datetime',

        'payment_enabled' => 'boolean',
        'payment_proof_required' => 'boolean',

        'price_variations' => 'array',

        'show_title' => 'boolean',
        'show_description' => 'boolean',
        'show_banner' => 'boolean',
        'show_date' => 'boolean',
        'show_time' => 'boolean',
        'show_location' => 'boolean',
        'show_price' => 'boolean',
        'show_quota' => 'boolean',
        'show_remaining_quota' => 'boolean',
        'show_registration_count' => 'boolean',

        'show_payment_after_submit' => 'boolean',

        'open_whatsapp_after_submit' => 'boolean',

        'email_notification_enabled' => 'boolean',
        'admin_notification_enabled' => 'boolean',
    ];


    public const CATEGORIES = [

        'touring' =>
            '🏍️ TOURING',

        'kopdar' =>
            '🤝 KOPDAR',

        'ride_out' =>
            '🏍️ RIDE OUT',

        'jacket_po' =>
            '👕 PEMBUATAN JAKET / OPEN PO',
    ];


    public const CATEGORY_DESCRIPTIONS = [

        'touring' =>
            'Touring antar kota, touring wisata, touring alam',

        'kopdar' =>
            'Kopdar rutin, kopdar gabungan, silaturahmi',

        'ride_out' =>
            'Sunday Ride, Night Ride, Morning Ride',

        'jacket_po' =>
            'Pemesanan dan pembuatan jaket Wacana Style',
    ];


    protected static function booted(): void
    {
        static::saving(function (Form $form) {

            if (empty($form->slug)) {

                $form->slug =
                    Str::slug($form->title);
            }


            /*
             * OPEN PO WAJIB BERBAYAR
             */
            if ($form->category === 'jacket_po') {

                $form->payment_enabled = true;
            }


            /*
             * PUBLISHED DATE
             */
            if (
                $form->status === 'open' &&
                empty($form->published_at)
            ) {

                $form->published_at = now();
            }
        });
    }


    public function fields()
    {
        return $this
            ->hasMany(FormField::class)
            ->orderBy('sort_order');
    }


    public function submissions()
    {
        return $this
            ->hasMany(FormSubmission::class);
    }


    public static function categoryOptions(): array
    {
        return self::CATEGORIES;
    }


    public function getRegistrationCountAttribute(): int
    {
        if ($this->relationLoaded('submissions')) {

            return $this->submissions->count();
        }

        return $this->submissions()->count();
    }


    public function getRemainingQuotaAttribute(): ?int
    {
        if (is_null($this->quota)) {

            return null;
        }

        return max(
            0,
            $this->quota - $this->registration_count
        );
    }


    public function getEffectivePriceAttribute(): float
    {
        if (
            !is_null($this->promo_price) &&
            (float) $this->promo_price > 0
        ) {

            return (float) $this->promo_price;
        }

        return (float) ($this->payment_amount ?? 0);
    }


    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('status', 'open');
    }


    public static function defaultFields(?string $category): array
    {
        $common = [

            [
                'label' => 'Nama Lengkap',
                'name' => 'nama_lengkap',
                'type' => 'text',
                'is_required' => true,
                'sort_order' => 1,
            ],

            [
                'label' => 'Nama Panggilan',
                'name' => 'nama_panggilan',
                'type' => 'text',
                'is_required' => true,
                'sort_order' => 2,
            ],

            [
                'label' => 'Nomor WhatsApp',
                'name' => 'nomor_whatsapp',
                'type' => 'tel',
                'placeholder' => '08xxxxxxxxxx',
                'validation_format' => 'phone',
                'is_required' => true,
                'sort_order' => 3,
            ],

            [
                'label' => 'Asal Kota / Daerah',
                'name' => 'asal_kota',
                'type' => 'text',
                'is_required' => true,
                'sort_order' => 4,
            ],

            [
                'label' => 'Tim / Chapter / Rombongan',
                'name' => 'tim_chapter',
                'type' => 'text',
                'is_required' => false,
                'sort_order' => 5,
            ],

            [
                'label' => 'Nama Komunitas',
                'name' => 'nama_komunitas',
                'type' => 'text',
                'is_required' => true,
                'sort_order' => 6,
            ],

            [
                'label' => 'Jenis Motor',
                'name' => 'jenis_motor',
                'type' => 'text',
                'is_required' => true,
                'sort_order' => 7,
            ],
        ];


        $riding = array_merge($common, [

            [
                'label' => 'Membawa Boncengan?',
                'name' => 'membawa_boncengan',
                'type' => 'radio',
                'options' => ['Ya', 'Tidak'],
                'is_required' => true,
                'sort_order' => 8,
            ],

            [
                'label' => 'Nama Boncengan',
                'name' => 'nama_boncengan',
                'type' => 'text',
                'is_required' => true,

                'conditional_enabled' => true,
                'conditional_field' => 'membawa_boncengan',
                'conditional_operator' => 'equals',
                'conditional_value' => 'Ya',

                'sort_order' => 9,
            ],

            [
                'label' => 'Nomor WhatsApp Boncengan',
                'name' => 'whatsapp_boncengan',
                'type' => 'tel',

                'placeholder' => '08xxxxxxxxxx',

                'is_required' => true,

                'conditional_enabled' => true,
                'conditional_field' => 'membawa_boncengan',
                'conditional_operator' => 'equals',
                'conditional_value' => 'Ya',

                'sort_order' => 10,
            ],

            [
                'label' => 'Catatan / Keterangan',
                'name' => 'catatan',
                'type' => 'textarea',
                'is_required' => false,
                'sort_order' => 11,
            ],
        ]);


        $presets = [

            'touring' => $riding,

            'kopdar' => $riding,

            'ride_out' => $riding,


            'jacket_po' => array_merge($common, [

                [
                    'label' => 'Ukuran Jaket',
                    'name' => 'ukuran_jaket',
                    'type' => 'select',

                    'options' => [
                        'S',
                        'M',
                        'L',
                        'XL',
                        'XXL',
                        'XXXL',
                    ],

                    'is_required' => true,
                    'is_price_field' => true,

                    'sort_order' => 8,
                ],

                [
                    'label' => 'Jumlah Jaket',
                    'name' => 'jumlah_jaket',
                    'type' => 'number',

                    'default_value' => '1',
                    'min_value' => 1,

                    'is_required' => true,

                    'sort_order' => 9,
                ],

                [
                    'label' => 'Nama untuk Dicetak',
                    'name' => 'nama_cetak',
                    'type' => 'text',

                    'is_required' => true,

                    'sort_order' => 10,
                ],

                [
                    'label' => 'Nomor / ID untuk Dicetak',
                    'name' => 'id_cetak',
                    'type' => 'text',

                    'is_required' => true,

                    'sort_order' => 11,
                ],

                [
                    'label' => 'Pengiriman Jaket',
                    'name' => 'pengiriman_jaket',
                    'type' => 'radio',

                    'options' => [
                        'Ambil Sendiri',
                        'Dikirim',
                    ],

                    'is_required' => true,

                    'sort_order' => 12,
                ],

                [
                    'label' => 'Alamat Lengkap',
                    'name' => 'alamat_lengkap',
                    'type' => 'textarea',

                    'is_required' => true,

                    'conditional_enabled' => true,
                    'conditional_field' => 'pengiriman_jaket',
                    'conditional_operator' => 'equals',
                    'conditional_value' => 'Dikirim',

                    'sort_order' => 13,
                ],

                [
                    'label' => 'Kecamatan',
                    'name' => 'kecamatan',
                    'type' => 'text',

                    'is_required' => true,

                    'conditional_enabled' => true,
                    'conditional_field' => 'pengiriman_jaket',
                    'conditional_operator' => 'equals',
                    'conditional_value' => 'Dikirim',

                    'sort_order' => 14,
                ],

                [
                    'label' => 'Kota / Kabupaten',
                    'name' => 'kota_kabupaten',
                    'type' => 'text',

                    'is_required' => true,

                    'conditional_enabled' => true,
                    'conditional_field' => 'pengiriman_jaket',
                    'conditional_operator' => 'equals',
                    'conditional_value' => 'Dikirim',

                    'sort_order' => 15,
                ],

                [
                    'label' => 'Kode Pos',
                    'name' => 'kode_pos',
                    'type' => 'text',

                    'is_required' => true,

                    'conditional_enabled' => true,
                    'conditional_field' => 'pengiriman_jaket',
                    'conditional_operator' => 'equals',
                    'conditional_value' => 'Dikirim',

                    'sort_order' => 16,
                ],

                [
                    'label' => 'Catatan / Permintaan Khusus',
                    'name' => 'catatan_khusus',
                    'type' => 'textarea',

                    'is_required' => false,

                    'sort_order' => 17,
                ],

                [
                    'label' => 'Persetujuan Ketentuan Jaket',
                    'name' => 'persetujuan',
                    'type' => 'checkbox',

                    'description' =>
                        'Saya telah membaca, memahami, dan menyetujui seluruh ketentuan pembelian serta pemakaian jaket Wacana Style.',

                    'is_required' => true,

                    'sort_order' => 18,
                ],
            ]),
        ];


        return $presets[$category] ?? [];
    }
}
