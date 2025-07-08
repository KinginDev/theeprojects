<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'name',
        'location', // header, footer, sidebar, etc.
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function items()
    {
        return $this->hasMany(MerchantMenuItem::class, 'menu_id')->whereNull('parent_id')->orderBy('order');
    }

    public function getTree()
    {
        $items = $this->items()->with('children')->get();
        return $items;
    }
}
