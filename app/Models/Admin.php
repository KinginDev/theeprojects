<?php
namespace App\Models;

use App\Models\Base\User;

class Admin extends User
{
    protected $guard    = 'admin';
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden   = ['password'];
}
