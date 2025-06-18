<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirtimeTransaction extends Model
{
    use HasFactory;

    protected $table = 'airtimes_transactions'; // Explicitly specify the table name

    protected $fillable = [
        'username',
        'network',
        'tel',
        'amount',
        'transaction_id',
        'identity',
        'percent_profit',
        'current_bal',
        'prev_bal',
        'status',
        'created_at',
        'updated_at',
    ];
}

