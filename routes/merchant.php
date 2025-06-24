<?php

use App\Http\Controllers\allPaymentController;
use App\Http\Controllers\Merchant\AuthController;
use App\Http\Controllers\Merchant\DashboardController;
use Illuminate\Support\Facades\Route;

Route::domain(config('app.domain'))->prefix('merchant')->name('merchant.')->group(function () {
    // Login Routes
    Route::get('/', function () {
        return "Help";
    })->name('home');
    Route::middleware('guest:merchant')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });

    //Register Routes
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.submit');
    // Protected Routes
    Route::middleware('auth:merchant')->group(function () {
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
        Route::post('create/{merchantId}', [DashboardController::class, 'createUser'])->name('users.create');

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
        Route::get('/walletSummary', [DashboardController::class, 'walletSummaryMerchant'])->name('walletSummary');
        Route::get('/message/user/{id}', [DashboardController::class, 'messageUser'])->name('message.user');
        Route::get('/add/account', [DashboardController::class, 'add_account'])->name('add_account');
        Route::get('/add/charge/{id}', [DashboardController::class, 'addCharge'])->name('add.charge');
        // add more routes here

        Route::get('/monnify-fee', [DashboardController::class, 'getMonnifyFee'])->name('getMonnifyFee');

    });
});
