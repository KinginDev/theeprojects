<?php
namespace App\Models;

use App\Models\Base\User;

class Merchant extends User
{
    protected $guard    = 'merchant';
    protected $fillable = ['name', 'email', 'password', 'slug', 'domain'];
    protected $hidden   = ['password'];

    protected const APP_DOMAIN = 'theeprojects.test';

    /**
     * Get the users for the merchant.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the full domain for the merchant.
     */
    public function getDomainAttribute()
    {
        return $this->attributes['domain'] ?? $this->slug . '.' . env('APP_DOMAIN', self::APP_DOMAIN);
    }

    /**
     * Check if a domain belongs to this merchant
     */
    public function hasDomain($domain)
    {
        return strtolower($this->domain) === strtolower($domain);
    }
}
