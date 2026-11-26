<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id', 'size', 'color', 'material_label', 'sku_suffix',
        'stock_quantity', 'low_stock_threshold', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function displayLabel(): string
    {
        $parts = array_filter([$this->size, $this->color, $this->material_label]);
        return $parts ? implode(' · ', $parts) : 'Standard';
    }
}
