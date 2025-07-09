<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantRole extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'permissions', 'merchant_id', 'is_default'];

    protected $casts = [
        'permissions' => 'array',
        'is_default' => 'boolean',
    ];

  public function merchants()
{
    return $this->belongsToMany(Merchant::class, 'merchant_role_user', 'role_id', 'merchant_id');
}
}
