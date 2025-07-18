<?php
namespace App\Models;

use App\Models\Base\BaseProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends BaseProduct
{
    use HasFactory;

    protected $table = 'wallet_transactions';

    protected $fillable = [
        'wallet_owner_id',   // owner_id of the wallet
        'wallet_owner_type', // owner_type of the wallet, e.g., App\Models\
        'wallet_id',         // App\Models\Merchant or App\Models\User
        'transaction_id',    // merchant_id or user_id
        'amount',
        'type', // credit or debit
        'description',
        'payload',
        'prev_balance',
        'current_balance',
    ];

    protected $casts = [
        'amount'          => 'decimal:2',
        'prev_balance'    => 'decimal:2',
        'current_balance' => 'decimal:2',
        'payload'       => 'array',
    ];

    /**
     * Get the wallet associated with this transaction
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Get the owner of the transaction (User or Merchant)
     * This is a polymorphic relationship based on wallet_owner_type and wallet_owner_id
     */
    public function owner()
    {
        return $this->morphTo(__FUNCTION__, 'wallet_owner_type', 'wallet_owner_id');
    }

}
