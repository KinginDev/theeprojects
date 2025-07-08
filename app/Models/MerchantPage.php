<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MerchantPage extends Model
{
    use HasFactory;


    protected $fillable = [
        'merchant_id',
        'title',
        'slug',
        'content',
        'meta_data',
        'is_published',
        'template',
        'is_home', // Indicates if this page is the home page
    ];

    protected $casts = [
        'meta_data' => 'array',
        'is_published' => 'boolean',
        'is_home' => 'boolean', // Indicates if this page is the home page
    ];

    // Set the slug from the title when saving
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (!$page->slug) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

      public static function getHomePage($merchantId)
    {
        return self::where('merchant_id', $merchantId)
            ->where('is_published', true)
            ->where('is_home', true)
            ->first();
    }

    // Relationships
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function menuItems()
    {
        return $this->hasMany(MerchantMenuItem::class, 'page_id');
    }
}
