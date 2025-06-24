<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantPreferences extends Model
{
    protected $table    = "merchant_preferences";
    protected $fillable = [
        'merchant_id',
    ];

}
