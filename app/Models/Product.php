<?php
namespace App\Models;

use App\Enums\ProductTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'price',
        'is_active',
        'image',
    ];

    protected $casts = [
        'type'      => ProductTypes::class,
        'is_active' => 'boolean',
    ];

   public function percentage()
    {
        return $this->hasOne(Percentage::class);
    }

    public function merchantPreferences()
    {
        return $this->hasMany(MerchantPreferences::class, 'merchant_id');
    }
}
