<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryZone extends Model
{
    protected $fillable = ['name', 'type', 'description', 'estimated_delay', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function rates(): HasMany
    {
        return $this->hasMany(ShippingRate::class);
    }
}
