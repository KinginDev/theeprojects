<?php
namespace App\Models;

use App\Enums\ProductTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * Product Model
 *
 * @property mixed $name
 * @property mixed $slug
 * @property mixed $service_name
 * @property mixed $type
 * @property mixed $description
 * @property mixed $price
 * @property mixed $is_active
 * @property mixed $image
 */
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
