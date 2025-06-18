<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceTransaction extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'insurance_transactions';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'username',
        'product_name',
        'type',
        'tel',
        'amount',
        'transaction_id',
        'purchased_code',
        'response_description',
        'transaction_date',
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
