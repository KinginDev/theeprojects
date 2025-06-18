<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',           // Referring user ID
        'referral_user_id',  // Referred user ID
        'referral_username', // Referred user username
    ];

   
    public function referrer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the referred user.
     */
    public function referredUser()
    {
        return $this->belongsTo(User::class, 'referral_user_id');
    }
}
