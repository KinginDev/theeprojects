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
}
