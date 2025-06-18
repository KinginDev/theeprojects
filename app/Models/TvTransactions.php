<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TvTransactions extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'tv_transactions';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'username',
        'api_response',
        'network',
        'tel',
        'plan',
        'amount',
        'transaction_id',
        'identity',
        'percent_profit',
        'current_bal',
        'prev_bal',
        'status',
    ];

    // If you want to cast some attributes to a specific type, you can use the $casts property
    protected $casts = [
        'transaction_date' => 'datetime',
        'amount' => 'decimal:2',
    ];
}
