<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider',
        'provider_charge_price',
        'recharge_date',
    ];
}
