<?php
namespace App\Models;

use App\Models\User;
use App\Notifications\MerchantVerify;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Str;

class Merchant extends User
{
    protected $guard    = 'merchant';
    protected $fillable = ['name', 'email', 'password', 'slug', 'domain', 'permissions'];
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

    public function sendEmailVerificationNotification()
    {
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
        return $this->hasOne(Wallet::class, 'owner_id', 'id')->where('owner_type', 'App\Models\Merchant');
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
        if($this->isSubMerchant()) {
            // If this is a sub-merchant, return the parent's domain
            return $this->parentMerchant->domain;
        }

        if (isset($this->attributes['domain']) &&
            ! str_contains($this->attributes['domain'], env('APP_DOMAIN', self::APP_DOMAIN))) {
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
            return (bool) $this->attributes['external_domain_active'];
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

        if($merchant->roles()->count() === 0) {
            // Create default roles if none exist
            self::createDefaultRoles($merchant->id);
        }

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

    public function roles()
    {
        return $this->belongsToMany(MerchantRole::class, 'merchant_role_user', 'merchant_id', 'role_id');
    }
    public function parentMerchant()
    {
        return $this->belongsTo(Merchant::class, 'parent_merchant_id');
    }

    public function subMerchants()
    {
        return $this->hasMany(Merchant::class, 'parent_merchant_id');
    }

    public function isAdmin()
    {
        return $this->roles()->where('slug', 'admin')->exists();
    }

    public function isSubMerchant()
    {
        return ! is_null($this->parent_merchant_id);
    }

    /**
     * Check if the merchant has a specific role
     *
     * @param string $role Role slug
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->roles()->where('slug', $role)->exists();
    }

/**
 * Assign a role to the merchant
 *
 * @param int|MerchantRole $role
 * @return void
 */
    public function assignRole($role)
    {
        if (is_numeric($role)) {
            dd('Assigning role by ID is deprecated. Please use the MerchantRole model instance instead.');

        } else {
            $this->roles()->attach($role->id);
        }
    }

/**
 * Remove a role from the merchant
 *
 * @param int|MerchantRole $role
 * @return void
 */
    public function removeRole($role)
    {
        if (is_numeric($role)) {
            $this->roles()->detach($role);
        } else {
            $this->roles()->detach($role->id);
        }
    }

/**
 * Check if the merchant has a specific permission
 *
 * @param string $permission
 * @return bool
 */
    public function hasPermission($permission)
    {
        // If merchant is owner, they have all permissions
        // If merchant has admin role, they have all permissions
        if ($this->roles()->where('slug', 'admin')->exists()) {
            return true;
        }

        // Check if any of the merchant's roles have this permission
        foreach ($this->roles as $role) {
            $permissions = is_array($role->permissions) ? $role->permissions : json_decode($role->permissions, true);
            if (in_array($permission, $permissions)) {
                return true;
            }
        }

        // Check direct permissions (stored in JSON)
        if (! empty($this->permissions)) {
            $directPermissions = is_array($this->permissions) ? $this->permissions : json_decode($this->permissions, true);
            return in_array($permission, $directPermissions);
        }

        return false;
    }


    /**
     * Create default roles for a merchant
     *
     * @param int $merchantId
     * @return void
     */
    public static function createDefaultRoles($merchantId)
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'Full access to all features',
                'permissions' => [
                    'manage_users', 'manage_merchants', 'manage_roles', 'view_transactions',
                    'fund_users', 'view_reports', 'manage_settings', 'manage_services',
                    'view_dashboard',
                ],
                'is_default' => true,
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
                'description' => 'Can manage users and transactions',
                'permissions' => [
                    'manage_users', 'view_transactions', 'fund_users', 'view_dashboard',
                ],
                'is_default' => true,
            ],
            [
                'name' => 'Staff',
                'slug' => 'staff',
                'description' => 'Can view reports and transactions',
                'permissions' => [
                    'view_transactions', 'view_reports', 'view_dashboard',
                ],
                'is_default' => true,
            ],
        ];

        foreach ($roles as $role) {
            MerchantRole::create([
                'name' => $role['name'],
                'slug' => $role['slug'],
                'description' => $role['description'],
                'permissions' => $role['permissions'],
                'merchant_id' => $merchantId,
                'is_default' => $role['is_default'],
            ]);
        }
    }
}
