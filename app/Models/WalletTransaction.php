<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $table = 'wallet_transactions';

    protected $fillable = [
        'wallet_id',      // App\Models\Merchant or App\Models\User
        'transaction_id', // merchant_id or user_id
        'amount',
        'type', // credit or debit
        'description',
        'meta_data',
        'prev_balance',
        'current_balance',
    ];

    protected $casts = [
        'amount'          => 'decimal:2',
        'prev_balance'    => 'decimal:2',
        'current_balance' => 'decimal:2',
        'meta_data'       => 'array',
    ];

    /**
     * Get the owner of the wallet transaction (merchant or user)
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

}
