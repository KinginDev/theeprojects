<?php
namespace App\Models;

use App\Models\Base\BaseProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataTransaction extends BaseProduct
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'api_response',
        'network',
        'tel',
        'plan',
        'amount',
        'reference',
        'identity',
        'percent_profit',
        'current_bal',
        'prev_bal',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
