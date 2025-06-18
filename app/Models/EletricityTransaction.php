<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EletricityTransaction extends Model
{
    use HasFactory;

    protected $table = 'eletricity_transactions'; // Explicitly specify the table name

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
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'amount' => 'decimal:2',
    ];
}
