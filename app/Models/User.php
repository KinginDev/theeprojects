<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\UserVerify;
use App\Models\Base\User as BaseUser;

class User extends BaseUser
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'referrer_id',
        'name',
        'username',
        'email',
        'tel',
        'address',
        'password',
        'role',
        'merchant_id', // Add merchant relationship
        'cal',
        'refferal_user',
        'refferal',
        'refferal_bonus',
        "smart_earners",
        'api_earners',
        'topuser_earners',
    ];

    /**
     * Get the merchant that owns the user.
     */
    public function merchants()
    {
        return $this->hasManyThrough(
            Merchant::class,
            MerchantUser::class,
            'user_id',    // Foreign key on the MerchantUser table
            'id',         // Foreign key on the Merchant table
            'id',         // Local key on the User table
            'merchant_id' // Local key on the MerchantUser table
        );
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new UserVerify());
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * Get all transactions for this user
     */
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactable');
    }

    /**
     * Get the user's wallet
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'owner_id', 'id')->where('owner_type', 'App\Models\User');
    }

    public static function boot()
    {
        parent::boot();

        // Automatically set user_id on creation
        static::created(function (User $user) {
            Wallet::create([
                'owner_type' => 'App\Models\User',
                'owner_id'   => $user->id,
                'balance'    => 0, // Initialize with zero balance
            ]);
        });
    }

    public function balance()
    {
        return $this->wallet->balance;
    }
}
