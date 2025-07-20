<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AllPaymentController;
use App\Http\Controllers\Merchant\authController;
use App\Http\Controllers\Merchant\MenuController;
use App\Http\Controllers\Merchant\PageController;
use App\Http\Controllers\Merchant\UserController;
use App\Http\Controllers\Merchant\MenuItemController;
use App\Http\Controllers\Merchant\DashboardController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::domain(config('app.domain'))->prefix('merchant')->name('merchant.')->group(function () {
    // Login Routes
    Route::get('/', function () {
        return "Help";
    })->name('home');

    Route::get('login', [authController::class, 'showLoginForm'])->name('login');
    Route::post('login', [authController::class, 'login'])->name('login.submit');
    Route::post('logout', [authController::class, 'logout'])->name('logout');
    Route::get('/forget/password', [authController::class, 'showForgetPasswordPage'])->name('show.password');
    Route::post('/forget/password', [authController::class, 'sendPasswordRequest'])->name('forget.password');
    Route::get('/password/reset/{token}', [authController::class, 'showResetForm'])->name('password.reset');
    Route::post('/update-password', [authController::class, 'updatePassword'])->name('update.password');


    Route::get('/merchant/submerchant-onboard/page/{token}', [authController::class, 'subMerchantOnboardShowPage'])
    ->name('onboarding.page');

     Route::get('/merchant/submerchant-onboard/notice/{token}', [authController::class, 'subMerchantOnboardNotice'])
    ->name('onboarding.notice');
    Route::post('/merchant/submerchant-onboard/store/{token}', [authController::class, 'subMerchantOnboardStore'])
    ->name('onboarding.store');


    // Email verification routes for merchants
    Route::get('/email/verify', function () {
        return view('merchant-layout.auth.verify');
    })->middleware('auth:merchant')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/merchant/dashboard')->with('success', 'Email verified successfully!');
    })->middleware(['auth:merchant', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', [authController::class, 'resendVerificationEmail'])->middleware(['auth:merchant', 'throttle:6,1'])->name('verification.send');

    //Register Routes
    Route::get('register', [authController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [authController::class, 'register'])->name('register.submit');
    // Protected Routes
    Route::middleware(['auth:merchant', 'verified'])->group(function () {
        Route::post('/make/payment', [AllPaymentController::class, 'makePayment'])->name('make.payment');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('users/{merchantId}', [DashboardController::class, 'getMerchantUsers'])->name('users');
        Route::get('/edit/user/{id}', [DashboardController::class, 'editUser'])->name('edit.user');
        Route::post('/update/user/{id}', [DashboardController::class, 'updateUser'])->name('update.user');
        Route::get('/deactivate/{id}', [DashboardController::class, 'deactivate'])->name('deactivate');
        Route::get('/activate/{id}', [DashboardController::class, 'activate'])->name('activate');
        Route::get('/delete/{id}', [DashboardController::class, 'delete'])->name('delete');
        Route::post('/fund/{id}', [DashboardController::class, 'fundUser'])->name('fund.user');
        Route::post('/approveFund/{id}', [DashboardController::class, 'approveFundUser'])->name('approveFund.user');
        Route::post('create/{merchantId}', [DashboardController::class, 'createUser'])->name('create.user');

        Route::get('/user/credit/account', [DashboardController::class, 'creditUserAccount'])->name('credit.user');
        Route::get('/add/fund/{userId}', [DashboardController::class, 'addFund'])->name('add.fund');
        Route::get('/approve/fund/{userId}', [DashboardController::class, 'approveFund'])->name('approve.fund');

        Route::get('/airtime', [DashboardController::class, 'merchantAirtime'])->name('airtime');
        Route::get('/data', [DashboardController::class, 'merchantData'])->name('data');
        Route::get('/electricity', [DashboardController::class, 'merchantElectricity'])->name('electricity');
        Route::get('/tv', [DashboardController::class, 'merchantTv'])->name('tv');
        Route::get('/tv', [DashboardController::class, 'merchantTv'])->name('tv');
        Route::get('/education', [DashboardController::class, 'merchantEducation'])->name('education');
        Route::get('/education', [DashboardController::class, 'merchantEducation'])->name('education');
        Route::get('/insurance', [DashboardController::class, 'merchantInsurance'])->name('insurance');
        Route::get('/message', [DashboardController::class, 'message'])->name('message');
        Route::get('/notification', [DashboardController::class, 'notification'])->name('notification');
        Route::get('/marchant', [DashboardController::class, 'marchant'])->name('marchant');
        Route::get('/site_setting', [DashboardController::class, 'site_setting'])->name('site_setting');
        Route::get('/edit_profile', [DashboardController::class, 'edit_profile'])->name('edit_profile');
        Route::put('/edit/{id}/profile', [DashboardController::class, 'updateProfile'])->name('update.profile');
        Route::post('/fund/charge/all/{id}', [DashboardController::class, 'addChargeAirtimeUser'])->name('addChargeAirtime.user');

        Route::get('/walletSummary', [DashboardController::class, 'walletSummaryMerchant'])->name('walletSummary');
        Route::get('/message/user/{id}', [DashboardController::class, 'messageUser'])->name('message.user');
        Route::get('/add/account', [DashboardController::class, 'add_account'])->name('add_account');
        Route::get('/add/charge/{id}', [DashboardController::class, 'addCharge'])->name('add.charge');
        // add more routes here

        Route::get('/monnify-fee', [DashboardController::class, 'getMonnifyFee'])->name('getMonnifyFee');
        Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');

        Route::put('/settings-update', [DashboardController::class, 'updateSetting'])->name('settings.update');
    });




    // CMS - Pages
    Route::resource('pages', PageController::class);

    // CMS - Menus
    Route::resource('menus', MenuController::class);

    // CMS - Menu Items
    Route::get('menus/sort', [MenuItemController::class, 'sort'])->name('menu-items.sort');
    Route::post('menus/{menu}/items', [MenuItemController::class, 'store'])->name('menu-items.store');
    Route::put('menu-items/{menuItem}', [MenuItemController::class, 'update'])->name('menu-items.update');
    Route::delete('menu-items/{menuItem}', [MenuItemController::class, 'destroy'])->name('menu-items.destroy');
    Route::post('menus/{menu}/reorder', [MenuItemController::class, 'reorder'])->name('menu-items.reorder');




      // Sub-merchant management
    Route::get('/sub-merchants', [UserController::class, 'manageMerchants'])
        ->name('manage-merchants')
        ->middleware('merchant.permission:manage_merchants');

    Route::get('/sub-merchants/create', [UserController::class, 'createSubMerchantForm'])
        ->name('create-sub-merchant-form')
        ->middleware('merchant.permission:manage_merchants');

    Route::post('/sub-merchants/store', [UserController::class, 'storeSubMerchant'])
        ->name('store-sub-merchant')
        ->middleware('merchant.permission:manage_merchants');

    Route::get('/sub-merchants/edit/{id}', [UserController::class, 'editSubMerchant'])
        ->name('edit-sub-merchant')
        ->middleware('merchant.permission:manage_merchants');

    Route::put('/sub-merchants/update/{id}', [UserController::class, 'updateSubMerchant'])
        ->name('update-sub-merchant')
        ->middleware('merchant.permission:manage_merchants');

    Route::get('/sub-merchants/toggle-status/{id}', [UserController::class, 'toggleSubMerchantStatus'])
        ->name('toggle-sub-merchant-status')
        ->middleware('merchant.permission:manage_merchants');

    // Role management
    Route::get('/roles', [UserController::class, 'manageRoles'])
        ->name('manage-roles')
        ->middleware('merchant.permission:manage_roles');

    Route::get('/roles/create', [UserController::class, 'createRoleForm'])
        ->name('create-role-form')
        ->middleware('merchant.permission:manage_roles');

    Route::post('/roles/store', [UserController::class, 'storeRole'])
        ->name('store-role')
        ->middleware('merchant.permission:manage_roles');

    Route::get('/roles/edit/{id}', [UserController::class, 'editRole'])
        ->name('edit-role')
        ->middleware('merchant.permission:manage_roles');

    Route::post('/roles/update/{id}', [UserController::class, 'updateRole'])
        ->name('update-role')
        ->middleware('merchant.permission:manage_roles');

    Route::delete('/roles/delete/{id}', [UserController::class, 'deleteRole'])
        ->name('delete-role')
        ->middleware('merchant.permission:manage_roles');
});
