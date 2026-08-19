<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JacketOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'jacket_type',
        'jacket_model',
        'colors',
        'sizes',
        'total_quantity',
        'design_reference',
        'notes',
        'status',
        'estimated_total',
        'ordered_at',
        'confirmed_at',
        'completed_at',
    ];

    protected $casts = [
        'colors' => 'array',
        'sizes' => 'array',
        'ordered_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (JacketOrder $order) {
            if (empty($order->order_number)) {
                $order->order_number = self::generateOrderNumber();
            }
            if (empty($order->ordered_at)) {
                $order->ordered_at = now();
            }
        });
    }

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber(): string
    {
        $year = now()->format('Y');
        $month = now()->format('m');
        $prefix = 'JKT-' . $year . $month . '-';

        $last = self::where('order_number', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->value('order_number');

        $nextNumber = 1;
        if ($last) {
            $lastNumber = (int) substr($last, -4);
            $nextNumber = $lastNumber + 1;
        }

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Scope: Get orders by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Get recent orders
     */
    public function scopeRecent($query)
    {
        return $query->orderByDesc('ordered_at');
    }

    /**
     * Check if order can be edited
     */
    public function canEdit(): bool
    {
        return in_array($this->status, ['new', 'processing']);
    }

    /**
     * Check if order can be confirmed
     */
    public function canConfirm(): bool
    {
        return $this->status === 'processing';
    }

    /**
     * Check if order can be completed
     */
    public function canComplete(): bool
    {
        return in_array($this->status, ['processing', 'confirmed']);
    }

    /**
     * Check if order can be cancelled
     */
    public function canCancel(): bool
    {
        return in_array($this->status, ['new', 'processing']);
    }

    /**
     * Confirm the order
     */
    public function confirm(): void
    {
        if ($this->canConfirm()) {
            $this->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);
        }
    }

    /**
     * Complete the order
     */
    public function complete(): void
    {
        if ($this->canComplete()) {
            $this->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
        }
    }

    /**
     * Cancel the order
     */
    public function cancel(): void
    {
        if ($this->canCancel()) {
            $this->update(['status' => 'cancelled']);
        }
    }
}
