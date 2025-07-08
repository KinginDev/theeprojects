<?php
namespace App\Models;

use App\Models\Base\BaseProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AirtimeTransaction extends BaseProduct
{
    use HasFactory;

    protected $table = 'airtimes_transactions'; // Explicitly specify the table name

    protected $fillable = [
        'user_id',
        'transaction_id',
        'network',
        'tel',
        'amount',
        'reference',
        'identity',
        'percent_profit',
        'current_bal',
        'prev_bal',
        'status',
        'created_at',
        'updated_at',
    ];



}
