<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\usersController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    // Authenticated routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/admin/generate-user-emails-csv', [usersController::class, 'generateUserEmailsCSV'])->name('generateUserEmailsCSV');
        Route::get('/dashboard', [adminController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/users', [adminController::class, 'manage'])->name('manage');
        Route::get('/users/credit/account', [adminController::class, 'creditUserAccount'])->name('creditUserAccount');
        Route::get('/airtime', [adminController::class, 'adminAirtime'])->name('adminAirtime');
        Route::get('/data', [adminController::class, 'adminData'])->name('adminData');
        Route::get('/electricity', [adminController::class, 'adminElectricity'])->name('adminElectricity');
        Route::get('/tv', [adminController::class, 'adminTv'])->name('adminTv');
        Route::get('/education', [adminController::class, 'adminEducation'])->name('adminEducation');
        Route::get('/insurance', [adminController::class, 'adminInsurance'])->name('adminInsurance');
        Route::get('/message', [adminController::class, 'message'])->name('message');
        Route::get('/notification', [adminController::class, 'notification'])->name('notification');
        Route::get('/site_setting', [adminController::class, 'site_setting'])->name('site_setting');
        Route::get('/edit_profile', [adminController::class, 'edit_profile'])->name('edit_profile');
        Route::get('/add/charge/{id}', [adminController::class, 'addCharge'])->name('add.charge');
        Route::get('/edit/user/{id}', [adminController::class, 'editUser'])->name('edit.user');
        Route::get('/add/fund/{id}', [adminController::class, 'addFund'])->name('add.fund');
        Route::get('/approve/fund/{id}', [adminController::class, 'approveFund'])->name('approve.fund');
        Route::post('/update/user/{id}', [adminController::class, 'updateUser'])->name('update.user');
        Route::get('/deactivate/{id}', [adminController::class, 'deactivate'])->name('deactivate');
        Route::get('/activate/{id}', [adminController::class, 'activate'])->name('activate');
        Route::get('/delete/{id}', [adminController::class, 'delete'])->name('delete');
        Route::post('/fund/{id}', [adminController::class, 'fundUser'])->name('fund.user');
        Route::post('/approveFund/{id}', [adminController::class, 'approveFundUser'])->name('approveFund.user');
        Route::get('admin/message/user/{id}', [adminController::class, 'messageUser'])->name('message.user');
        Route::post('/fund/charge/all/{id}', [adminController::class, 'addChargeAirtimeUser'])->name('addChargeAirtime.user');
        Route::post('/send-message/{id}', [adminController::class, 'sendMessage'])->name('admin.sendMessage');
        Route::get('/walletSummary', [adminController::class, 'walletSummaryadmin'])->name('walletSummary');
        Route::get('/add/account', [adminController::class, 'add_account'])->name('add_account');
        Route::post('/new/account', [adminController::class, 'addnewAccount'])->name('admin.addnewAccount');
        Route::get('/marchant', [adminController::class, 'marchant'])->name('marchant');
        Route::get('/manageSubAdmin/{id}', [adminController::class, 'manageSubAdmin'])->name('manageSubAdmin');
        Route::post('/update-page-status/{id}/{action}', [adminController::class, 'updatePageStatus'])->name('updatePageStatus');

        // // Merchant management
        // Route::resource('merchants', MerchantController::class);

        // // User management
        // Route::resource('users', UserController::class);
    });
});
