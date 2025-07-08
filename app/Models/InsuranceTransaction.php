<?php
namespace App\Models;

use App\Models\Base\BaseProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InsuranceTransaction extends BaseProduct
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
        'reference',
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
        'amount'           => 'decimal:2',
    ];
}
