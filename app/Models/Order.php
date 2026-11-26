<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'tracking_token', 'user_id', 'courier_id', 'promo_code_id', 'delivery_zone_id',
        'civility', 'customer_name', 'customer_phone', 'customer_email',
        'delivery_mode', 'delivery_country', 'delivery_city', 'delivery_address',
        'postal_code', 'gps_landmark', 'delivery_slot', 'carrier_tracking_number',
        'subtotal', 'discount_amount', 'shipping_amount', 'total_amount',
        'payment_method', 'payment_status', 'is_simulated_payment', 'status',
    ];

    protected function casts(): array
    {
        return ['is_simulated_payment' => 'boolean'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function courier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'courier_id');
    }

    public function promoCode(): BelongsTo
    {
        return $this->belongsTo(PromoCode::class);
    }

    public function deliveryZone(): BelongsTo
    {
        return $this->belongsTo(DeliveryZone::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(OrderEvent::class)->orderBy('created_at');
    }
}
