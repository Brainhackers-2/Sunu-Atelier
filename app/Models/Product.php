<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'artisan_id', 'technique_id', 'title', 'slug', 'sku',
        'availability_type', 'manufacturing_days', 'price_public', 'price_compare_at',
        'price_pro', 'weight_grams', 'dimensions', 'short_description', 'description',
        'materials_story', 'care_instructions', 'authenticity_guarantee', 'model_3d_path',
        'is_bestseller', 'is_new', 'is_active',
    ];

    /**
     * Never expose wholesale price in default JSON/array serialization.
     */
    protected $hidden = ['price_pro'];

    protected function casts(): array
    {
        return [
            'is_bestseller' => 'boolean',
            'is_new' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function artisan(): BelongsTo
    {
        return $this->belongsTo(Artisan::class);
    }

    public function technique(): BelongsTo
    {
        return $this->belongsTo(Technique::class);
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function totalStock(): int
    {
        return (int) $this->variants()->where('is_active', true)->sum('stock_quantity');
    }

    public function isAvailableForPurchase(): bool
    {
        if (! $this->is_active) {
            return false;
        }
        if ($this->availability_type === 'sur_commande') {
            return true;
        }
        return $this->totalStock() > 0;
    }

    public function formattedPrice(): string
    {
        return number_format($this->price_public, 0, ',', ' ') . ' FCFA';
    }
}
