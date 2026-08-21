<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'label',
        'name',
        'type',
        'placeholder',
        'description',
        'options',
        'validation_rules',
        'is_required',
        'sort_order',
    ];

    protected $casts = [
        'options' => 'array',
        'validation_rules' => 'array',
        'is_required' => 'boolean',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    /**
     * Normalisasi daftar opsi menjadi array.
     *
     * Mendukung berbagai format penyimpanan:
     *  - array (sudah dicast oleh model)
     *  - string JSON  : ["S","M","L"]
     *  - string teks  : "S, M, L" atau "Ya\nTidak"
     */
    public function optionsList(): array
    {
        $raw = $this->options;

        if (is_array($raw)) {
            return array_values(array_filter($raw, fn ($value) => $value !== null && $value !== ''));
        }

        if (is_string($raw) && trim($raw) !== '') {
            $decoded = json_decode($raw, true);

            if (is_array($decoded)) {
                return array_values(array_filter($decoded, fn ($value) => $value !== null && $value !== ''));
            }

            $options = preg_split('/[\r\n,]+/', $raw);

            return array_values(array_filter(array_map('trim', $options), fn ($value) => $value !== ''));
        }

        return [];
    }

    /**
     * Apakah field checkbox tunggal (tanpa daftar pilihan)?
     * Dipakai untuk checkbox persetujuan yang wajib dicentang.
     */
    public function isSingleCheckbox(): bool
    {
        return $this->type === 'checkbox' && count($this->optionsList()) === 0;
    }
}