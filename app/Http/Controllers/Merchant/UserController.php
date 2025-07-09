<?php

namespace App\Http\Controllers\Merchant;

use App\Models\User;
use App\Models\Merchant;
use Illuminate\Support\Str;
use App\Models\MerchantRole;
use App\Models\MerchantUser;
use Illuminate\Http\Request;
use App\Mail\OnboardSubMerchant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public function manageMerchants()
    {
        // Logic to manage merchants
        $merchant = Auth::guard('merchant')->user();

        if(!($merchant->isAdmin()) && !$merchant->hasPermission('manage_merchants')) {
            return redirect()->route('merchant.dashboard')
            ->with('error', 'You do not have permission to manage sub-merchants');
        }


        $subMerchants = Merchant::where('parent_merchant_id', $merchant->id)
        ->orderBy('created_at', 'desc')
        ->get();

        // Get available roles
        $roles = MerchantRole::where('merchant_id', $merchant->id)->get();

        return view('merchant-layout.sub-merchants.manage', compact(
            'subMerchants',
            'roles'
        ));

    }

    public function createSubMerchantForm(Request $request)
    {
        // Logic to show the form for creating a sub-merchant
        $merchant = Auth::guard('merchant')->user();

        if(!($merchant->isAdmin()) && !$merchant->hasPermission('manage_merchants')) {
            return redirect()->route('merchant.dashboard')
            ->with('error', 'You do not have permission to create sub-merchants');
        }
        // Get available roles
        $roles = MerchantRole::where('merchant_id', $merchant->id)->get();

        // If no roles exist, create default roles
        if ($roles->isEmpty()) {
            Merchant::createDefaultRoles($merchant->id);
            $roles = MerchantRole::where('merchant_id', $merchant->id)->get();
        }

        return view('merchant-layout.sub-merchants.create', compact( 'roles'));
    }

    public function storeSubMerchant(Request $request){
        $parentMerchant = Auth::guard('merchant')->user();

        if(!$parentMerchant->isAdmin() && !$parentMerchant->hasPermission('manage_merchants')) {
            return redirect()->route('merchant.dashboard')
            ->with('error', 'You do not have permission to create sub-merchants');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:merchants,email',
            'phone' => 'nullable|string',
            'role_id' => 'required|exists:merchant_roles,id',
            'custom_permissions' => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();
            $selectedRole = $validatedData['role_id'];
            $permissions = [];

            if ($selectedRole === 'custom' && isset($validatedData['custom_permissions'])) {
                $permissions = $validatedData['custom_permissions'];
            } else {
                $role = MerchantRole::where('merchant_id', $parentMerchant->id)
                    ->where('id', $selectedRole)
                    ->first();

                if ($role) {
                    $permissions = $role->permissions;
                }
            }

            $subMerchant = new Merchant();
            $subMerchant->name = $validatedData['name'];
            $subMerchant->slug = Str::slug($validatedData['name']);
            $subMerchant->email = $validatedData['email'];
            $subMerchant->parent_merchant_id = $parentMerchant->id;
            $subMerchant->phone = $validatedData['phone'];
            $subMerchant->domain = $parentMerchant->domain;

            $subMerchant->token = Str::random(60); // Generate a token for onboarding
            $subMerchant->save();
            // Assign permissions based on role
            if ($selectedRole !== 'custom') {
                $subMerchant->assignRole($role);
            } else {
                $subMerchant->update([
                    'permissions' => $permissions]);

            }

            Mail::to($subMerchant->email)->send(new OnboardSubMerchant(
                $subMerchant,
                $parentMerchant
            ));

            DB::commit();
            return redirect()->route('merchant.create-sub-merchant-form', )
                ->with('success', 'Sub-merchant created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('merchant.create-sub-merchant-form')
                ->with('error', 'An error occurred while creating the sub-merchant: ' . $e->getMessage());
        }
    }

    public function manageRoles()
    {
        // Logic to manage roles
        $merchant = Auth::guard('merchant')->user();

        if(!($merchant->isAdmin()) && !$merchant->hasPermission('manage_roles')) {
            return redirect()->route('merchant.dashboard')
            ->with('error', 'You do not have permission to manage roles');
        }

        $roles = MerchantRole::where('merchant_id', $merchant->id)->get();
        if($roles->isEmpty()) {
            Merchant::createDefaultRoles($merchant->id);
            $roles = MerchantRole::where('merchant_id', $merchant->id)->get();
        }

        return view('merchant-layout.roles.manage-roles', compact('roles'));
    }

    /**
     * Edit a role
     *
     * @param int $roleId
     * @return mixed
     */
    public function editRole($roleId)
    {
        $merchant = Auth::guard('merchant')->user();

        // Check permission
        if (!$merchant->isAdmin() && !$merchant->hasPermission('manage_roles')) {
            return redirect()->route('merchant.dashboard')
                ->with('error', 'You do not have permission to manage roles');
        }

        // Find the role
        $role = MerchantRole::where('id', $roleId)
            ->where('merchant_id', $merchant->id)
            ->firstOrFail();

        // List of available permissions
        $availablePermissions = [
            'manage_users' => 'Manage Users',
            'manage_merchants' => 'Manage Sub-Merchants',
            'manage_roles' => 'Manage Roles',
            'view_transactions' => 'View Transactions',
            'fund_users' => 'Fund User Accounts',
            'view_reports' => 'View Reports',
            'manage_settings' => 'Manage Settings',
            'manage_services' => 'Manage Services',
            'view_dashboard' => 'View Dashboard',
        ];

        return view('merchant-layout.roles.edit-role', compact('role', 'availablePermissions'));
    }


    /**
     * Show form to create a new role
     *
     * @return mixed
     */
    public function createRoleForm()
    {
        $merchant = Auth::guard('merchant')->user();

        // Check permission
        if (!$merchant->isAdmin() && !$merchant->hasPermission('manage_roles')) {
            return redirect()->route('merchant.dashboard')
                ->with('error', 'You do not have permission to manage roles');
        }

        // List of available permissions
        $availablePermissions = [
            'manage_users' => 'Manage Users',
            'manage_merchants' => 'Manage Sub-Merchants',
            'manage_roles' => 'Manage Roles',
            'view_transactions' => 'View Transactions',
            'fund_users' => 'Fund User Accounts',
            'view_reports' => 'View Reports',
            'manage_settings' => 'Manage Settings',
            'manage_services' => 'Manage Services',
            'view_dashboard' => 'View Dashboard',
        ];

        return view('merchant-layout.roles.create-role', compact('availablePermissions'));
    }

    /**
     * Store a new role
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeRole(Request $request)
    {
        $merchant = Auth::guard('merchant')->user();

        // Check permission
        if (!$merchant->isAdmin() && !$merchant->hasPermission('manage_roles')) {
            return redirect()->route('merchant.dashboard')
                ->with('error', 'You do not have permission to manage roles');
        }

        // Validate request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'required|array',
            'is_default' => 'nullable|boolean',
        ]);

        try {
            // Create the role
            MerchantRole::create([
                'name' => $validatedData['name'],
                'slug' => \Str::slug($validatedData['name']),
                'description' => $validatedData['description'] ?? '',
                'permissions' => $validatedData['permissions'],
                'merchant_id' => $merchant->id,
                'is_default' => isset($validatedData['is_default']) && $validatedData['is_default'] ? true : false,
            ]);

            return redirect()->route('merchant.manage-roles')
                ->with('success', 'Role created successfully');
        } catch (\Exception $e) {
            return redirect()->route('merchant.manage-roles')
                ->with('error', 'Failed to create role: ' . $e->getMessage());
        }
    }


    /**
     * Update a role
     *
     * @param \Illuminate\Http\Request $request
     * @param int $roleId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRole(Request $request, $roleId)
    {
        $merchant = Auth::guard('merchant')->user();


        // Check permission
        if (!$merchant->isAdmin() && !$merchant->hasPermission('manage_roles')) {
            return redirect()->route('merchant.dashboard')
                ->with('error', 'You do not have permission to manage roles');
        }
        // Validate request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'required|array',
            'is_default' => 'nullable|boolean',
        ]);

        // Find the role
        $role = MerchantRole::where('id', $roleId)
            ->where('merchant_id', $merchant->id)
            ->firstOrFail();



        try {
            // Update the role
            $role->name = $validatedData['name'];
            $role->slug = \Str::slug($validatedData['name']);
            $role->description = $validatedData['description'] ?? '';
            $role->permissions = $validatedData['permissions'];
            $role->is_default = isset($validatedData['is_default']) && $validatedData['is_default'] ? true : false;
            $role->save();

            return redirect()->route('merchant.manage-roles')
                ->with('success', 'Role updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('merchant.manage-roles')
                ->with('error', 'Failed to update role: ' . $e->getMessage());
        }
    }

    /**
     * Delete a role
     *
     * @param int $roleId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteRole($roleId)
    {
        $merchant = Auth::guard('merchant')->user();

        // Check permission
        if ($merchant->isSubMerchant() && !$merchant->hasPermission('manage_roles')) {
            return redirect()->route('merchant.dashboard')
                ->with('error', 'You do not have permission to manage roles');
        }

        // Find the role
        $role = MerchantRole::where('id', $roleId)
            ->where('merchant_id', $merchant->id)
            ->firstOrFail();

        // Cannot delete default roles
        if ($role->is_default) {
            return redirect()->route('merchant.manage-roles')
                ->with('error', 'Cannot delete default roles');
        }

        try {
            // Check if any sub-merchants are using this role
            $roleInUse = Merchant::where('parent_merchant_id', $merchant->id)
                ->where('role', $role->slug)
                ->exists();

            if ($roleInUse) {
                return redirect()->route('merchant.manage-roles')
                    ->with('error', 'This role is assigned to one or more sub-merchants and cannot be deleted');
            }

            $role->delete();

            return redirect()->route('merchant.manage-roles')
                ->with('success', 'Role deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('merchant.manage-roles')
                ->with('error', 'Failed to delete role: ' . $e->getMessage());
        }
    }

}



