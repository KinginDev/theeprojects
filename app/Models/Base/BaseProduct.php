<?php
namespace App\Models\Base;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;

abstract class BaseProduct extends Model
{
    public $appends = ['type', 'transaction_ref', 'logo'];
    public function getTypeAttribute(): string
    {
        return $this->transaction->type;
    }

    public function getTransactionRefAttribute(): string
    {
        return $this->transaction->reference;
    }

    public function getLogoAttribute(): string
    {
        if ($this->network) {
            return \Str::title($this->network);
        }

        return '';

    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

      public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
