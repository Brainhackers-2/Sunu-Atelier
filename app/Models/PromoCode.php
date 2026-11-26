<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order_amount',
        'max_uses', 'used_count', 'starts_at', 'expires_at', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function isValidForAmount(int $subtotal): bool
    {
        if (! $this->is_active) {
            return false;
        }
        $now = now();
        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }
        if ($this->expires_at && $now->gt($this->expires_at)) {
            return false;
        }
        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) {
            return false;
        }
        return $subtotal >= $this->min_order_amount;
    }

    public function calculateDiscount(int $subtotal): int
    {
        if (! $this->isValidForAmount($subtotal)) {
            return 0;
        }
        if ($this->type === 'percentage') {
            return (int) round($subtotal * min(100, $this->value) / 100);
        }
        return min($subtotal, $this->value);
    }
}
