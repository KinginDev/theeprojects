<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'tel',
        'amount',
        'reference',
        'identity',
        'status',
        'prev_bal',
        'current_bal',
    ];
}
