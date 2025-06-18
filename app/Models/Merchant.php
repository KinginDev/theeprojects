<?php
namespace App\Models;

use App\Models\Base\User;

class Merchant extends User
{
    protected $guard    = 'merchant';
    protected $fillable = ['name', 'email', 'password', 'slug', 'domain'];
    protected $hidden   = ['password'];

    protected const APP_DOMAIN = 'theeprojects.test';

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->domain = str_replace(' ', '_', strtolower($model->name)) . '.' . self::APP_DOMAIN;
            $model->save();
        });
    }
}
