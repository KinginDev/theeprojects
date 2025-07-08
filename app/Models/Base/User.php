<?php
namespace App\Models\Base;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
}
