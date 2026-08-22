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

        'default_value',

        'validation_rules',

        'min_length',
        'max_length',

        'min_value',
        'max_value',

        'validation_format',

        'width',

        'group',
        'is_full_width',

        'is_required',

        'conditional_enabled',
        'conditional_field',
        'conditional_operator',
        'conditional_value',

        'is_price_field',

        'sort_order',
    ];

    protected $casts = [
        'options' => 'array',
        'validation_rules' => 'array',

        'is_required' => 'boolean',
        'is_full_width' => 'boolean',

        'conditional_enabled' => 'boolean',
        'is_price_field' => 'boolean',

        'min_length' => 'integer',
        'max_length' => 'integer',

        'min_value' => 'float',
        'max_value' => 'float',

        'sort_order' => 'integer',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function optionsList(): array
    {
        $raw = $this->options;

        if (is_array($raw)) {
            return array_values(array_filter(
                $raw,
                fn ($value) =>
                    $value !== null &&
                    $value !== ''
            ));
        }

        if (is_string($raw) && trim($raw) !== '') {
            $decoded = json_decode($raw, true);

            if (is_array($decoded)) {
                return array_values(array_filter($decoded));
            }

            $options = preg_split(
                '/[\r\n,]+/',
                $raw
            );

            return array_values(array_filter(
                array_map('trim', $options)
            ));
        }

        return [];
    }

    public function isSingleCheckbox(): bool
    {
        return
            $this->type === 'checkbox' &&
            count($this->optionsList()) === 0;
    }

    public function hasCondition(): bool
    {
        return
            $this->conditional_enabled &&
            filled($this->conditional_field);
    }
}
