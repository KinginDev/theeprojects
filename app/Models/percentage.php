<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Percentage extends Model
{
    use HasFactory;

    protected $fillable = [
        'service',
        'smart_earners_percent',
        'topuser_earners_percent',
        'api_earners_percent',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
