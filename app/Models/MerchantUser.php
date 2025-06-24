<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantUser extends Model
{
    protected $table = 'merchant_users';

    protected $fillable = [
        'merchant_id',
        'user_id',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
