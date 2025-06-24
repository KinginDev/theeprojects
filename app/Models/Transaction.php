<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    protected $fillable = [
        'reference',
        'transactable_type', // 'App\Models\Merchant' or 'App\Models\User'
        'transactable_id',   // merchant_id or user_id
        'amount',
        'type',               // transaction type (airtime, data, tv, etc.)
        'status',             // 'pending', 'success', 'failed'
        'payload',            // transaction details as JSON
        'provider_reference', // reference from service provider
    ];

    protected $casts = [
        'amount'  => 'decimal:2',
        'payload' => 'array',
    ];

    /**
     * Get the owner of the transaction (merchant or user)
     */
    public function transactable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function initialize($data)
    {
        $requiredProps = ['transactable_type', 'transactable_id', 'amount', 'payload'];

        foreach ($requiredProps as $prop) {
            if (! isset($data[$prop])) {
                throw new \InvalidArgumentException("Missing required property: $prop");
            }
        }

        // Create the transaction
        $transaction = new self([
            'transactable_type'  => $data['transactable_type'],
            'transactable_id'    => $data['transactable_id'],
            'amount'             => $data['amount'],
            'type'               => $data['type'] ?? 'general',
            'status'             => 'pending',
            'payload'            => $data['payload'],
            'provider_reference' => $data['provider_reference'] ?? null,
        ]);
        $transaction->reference = 'TRX' . strtoupper(uniqid());
        $transaction->save();

        return $transaction;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->reference)) {
                $model->reference = 'TRX' . strtoupper(uniqid());
            }
        });
    }
}
