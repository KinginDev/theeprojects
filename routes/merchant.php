<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\allPaymentController;
use App\Http\Controllers\Merchant\AuthController;
use App\Http\Controllers\Merchant\MenuController;
use App\Http\Controllers\Merchant\PageController;
use App\Http\Controllers\Merchant\MenuItemController;
use App\Http\Controllers\Merchant\DashboardController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::domain(config('app.domain'))->prefix('merchant')->name('merchant.')->group(function () {
    // Login Routes
    Route::get('/', function () {
        return "Help";
    })->name('home');

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/forget/password', [AuthController::class, 'showForgetPasswordPage'])->name('show.password');
    Route::post('/forget/password', [AuthController::class, 'sendPasswordRequest'])->name('forget.password');
    Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('update.password');

    // Email verification routes for merchants
    Route::get('/email/verify', function () {
        return view('merchant-layout.auth.verify');
    })->middleware('auth:merchant')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/merchant/dashboard')->with('success', 'Email verified successfully!');
    })->middleware(['auth:merchant', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])->middleware(['auth:merchant', 'throttle:6,1'])->name('verification.send');

    //Register Routes
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.submit');
    // Protected Routes
    Route::middleware(['auth:merchant', 'verified'])->group(function () {
        Route::post('/make/payment', [allPaymentController::class, 'makePayment'])->name('make.payment');
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
    Route::post('menus/{menu}/items', [MenuItemController::class, 'store'])->name('menu-items.store');
    Route::put('menu-items/{menuItem}', [MenuItemController::class, 'update'])->name('menu-items.update');
    Route::delete('menu-items/{menuItem}', [MenuItemController::class, 'destroy'])->name('menu-items.destroy');
    Route::post('menus/{menu}/reorder', [MenuItemController::class, 'reorder'])->name('menu-items.reorder');
});
