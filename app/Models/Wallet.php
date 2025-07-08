<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{

    protected $fillable = [
        'owner_type', // App\Models\Merchant or App\Models\User
        'owner_id',   // merchant_id or user_id
        'balance',
        'currency',
    ];

    public function owner()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->morphTo("App\Models\User", 'owner_type', 'owner_id');
    }

    public function merchant()
    {
        return $this->morphTo("App\Models\Merchant", 'owner');
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class, 'wallet_id');
    }

}
