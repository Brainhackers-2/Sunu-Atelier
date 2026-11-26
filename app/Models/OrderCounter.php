<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCounter extends Model
{
    protected $primaryKey = 'year_month';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['year_month', 'last_sequence'];
}
