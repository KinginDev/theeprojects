<?php
namespace App\Models;

use App\Models\Base\BaseProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ElectricityTransaction extends BaseProduct
{
    use HasFactory;

    protected $table = 'electricity_transactions'; // Explicitly specify the table name

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
        'created_at',
        'updated_at',
        "transaction_id",
        'user_id',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'amount'           => 'decimal:2',
    ];

    public $appends = ['meter_type'];

    public function getMeterTypeAttribute(): string
    {
        return $this->attributes['type'] ?? '';
    }
}
