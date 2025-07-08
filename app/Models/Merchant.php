<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
use App\Notifications\MerchantVerify;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class Merchant extends User
{
    protected $guard    = 'merchant';
    protected $fillable = ['name', 'email', 'password', 'slug', 'domain'];
    protected $hidden   = ['password'];

    protected $with = ['preferences'];

    protected $appends = ['external_domain_active'];

    protected const APP_DOMAIN = 'theeprojects.test';

    /**
     * Get the users for the merchant.
     */
    public function users()
    {
        return $this->hasManyThrough(
            User::class,
            MerchantUser::class,
            'merchant_id',
            'id',
            'id',
            'user_id'
        );
    }

    public function sendEmailVerificationNotification(){
        $this->notify(new MerchantVerify());
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect('/merchant/dashboard');
    }

    /**
     * Get the merchant's preferences
     */
    public function preferences()
    {
        return $this->hasOne(MerchantPreferences::class, 'merchant_id', 'id');
    }

    /**
     * Get the merchant's wallet
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'owner_id', 'id');
    }




    // Method to get the homepage
    public function getHomePage()
    {
        return $this->pages()
            ->where('is_published', true)
            ->where('is_home', true)
            ->first();
    }

    public function pages()
    {
        return $this->hasMany(MerchantPage::class, 'merchant_id', 'id');
    }

    public function menus()
    {
        return $this->hasMany(MerchantMenu::class, 'merchant_id', 'id');
    }

    // Update the getDomainAttribute method to accommodate direct domain setting
    public function getDomainAttribute()
    {
            // If domain is already set (and not a subdomain of our app), return it as-is
            if (isset($this->attributes['domain']) &&
                !str_contains($this->attributes['domain'], env('APP_DOMAIN', self::APP_DOMAIN))) {
                return $this->attributes['domain'];
            }

            // Otherwise return the default subdomain
            return $this->attributes['domain'] ?? $this->slug . '.' . env('APP_DOMAIN', self::APP_DOMAIN);
        }

        // Update or add the getExternalDomainActiveAttribute method
    public function getExternalDomainActiveAttribute()
    {
        // Check if external_domain_active is set in attributes
        if (isset($this->attributes['external_domain_active'])) {
            return (bool)$this->attributes['external_domain_active'];
        }

        // Default to false
        return false;
    }

    /**
     * Check if a domain belongs to this merchant
     */
    public function hasDomain($domain)
    {
        return strtolower($this->domain) === strtolower($domain);
    }

    public static function createMerchant(array $data)
    {
        $requiredProps = ['name', 'email', 'password'];

        for ($i = 0; $i < count($requiredProps); $i++) {
            if (! isset($data[$requiredProps[$i]])) {
                throw new \InvalidArgumentException("Missing required property: {$requiredProps[$i]}");
            }
        }
        $merchant           = new self();
        $merchant->name     = $data['name'];
        $merchant->email    = $data['email'];
        $merchant->slug     = Str::slug($data['name']);
        $merchant->phone    = $data['phone'] ?? null;
        $merchant->password = bcrypt($data['password']);
        $merchant->domain   = strtolower($merchant->slug) . '.' . env('APP_DOMAIN', self::APP_DOMAIN);
        $merchant->save();

        return $merchant;
    }

    public function balance()
    {
        return $this->wallet->balance;
    }

    public static function boot()
    {
        parent::boot();

        static::created(function (Merchant $merchant) {
            // Create a wallet for the new merchant

            Wallet::create([
                'merchant_id' => $merchant->id,
                'balance'     => 0.00,
                'owner_id'    => $merchant->id,
                'owner_type'  => self::class,
            ]);

            $merchant->preferences()->create([
                'merchant_id' => $merchant->id,
            ]);
        });
    }

    /**
     * Get all transactions for this merchant
     */
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactable');
    }

    /**
     * Get all wallet transactions for this merchant
     */
    public function walletTransactions()
    {
        return $this->morphMany(WalletTransaction::class, 'wallet_owner');
    }
}
