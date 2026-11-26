<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProProfile extends Model
{
    protected $fillable = [
        'user_id', 'company_name', 'ninea', 'trade_register', 'activity_type',
        'contact_name', 'whatsapp', 'address', 'estimated_monthly_volume',
        'discount_rate', 'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
