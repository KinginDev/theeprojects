<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MerchantMenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'parent_id',
        'title',
        'url',
        'page_id',
        'order',
        'target',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function menu()
    {
        return $this->belongsTo(MerchantMenu::class, 'menu_id');
    }

    public function parent()
    {
        return $this->belongsTo(MerchantMenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MerchantMenuItem::class, 'parent_id')->orderBy('order');
    }

    public function page()
    {
        return $this->belongsTo(MerchantPage::class, 'page_id');
    }

    // Get full URL, either from custom URL or page slug
     public function getUrlAttribute($value)
    {
        if ($value) {
            return $value;
        }

        if ($this->page) {
            return route('merchant.page.show', $this->page->slug);
        }

        return '#';
    }
}
