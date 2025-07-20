<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

Route::domain(config('app.domain'))
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
    // Public routes (no auth required)
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/forget_password', [AuthController::class, 'forget_password'])->name('forget_password');
    Route::post('/forgetPassword', [AuthController::class, 'forgetPasswordMail'])->name('users.forget_password');
    Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('updatePassword');

    // Protected routes - require admin authentication
    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/admin/generate-user-emails-csv', [UsersController::class, 'generateUserEmailsCSV'])->name('generateUserEmailsCSV');
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/users', [DashboardController::class, 'manage'])->name('manage');
        Route::get('/users/credit/account', [DashboardController::class, 'creditUserAccount'])->name('creditUserAccount');
        Route::get('/airtime', [DashboardController::class, 'adminAirtime'])->name('adminAirtime');
        Route::get('/data', [DashboardController::class, 'adminData'])->name('adminData');
        Route::get('/electricity', [DashboardController::class, 'adminElectricity'])->name('adminElectricity');
        Route::get('/tv', [DashboardController::class, 'adminTv'])->name('adminTv');
        Route::get('/education', [DashboardController::class, 'adminEducation'])->name('adminEducation');
        Route::get('/insurance', [DashboardController::class, 'adminInsurance'])->name('adminInsurance');
        Route::get('/message', [DashboardController::class, 'message'])->name('message');
        Route::get('/notification', [DashboardController::class, 'notification'])->name('notification');
        Route::get('/site_setting', [DashboardController::class, 'site_setting'])->name('site_setting');
        Route::get('/edit_profile', [DashboardController::class, 'edit_profile'])->name('edit_profile');
        Route::get('/add/charge/{id}', [DashboardController::class, 'addCharge'])->name('add.charge');
        Route::get('/edit/user/{id}', [DashboardController::class, 'editUser'])->name('edit.user');
        Route::get('/add/fund/{id}', [DashboardController::class, 'addFund'])->name('add.fund');
        Route::get('/approve/fund/{id}', [DashboardController::class, 'approveFund'])->name('approve.fund');
        Route::post('/update/user/{id}', [DashboardController::class, 'updateUser'])->name('update.user');
        Route::get('/deactivate/{id}', [DashboardController::class, 'deactivate'])->name('deactivate');
        Route::get('/activate/{id}', [DashboardController::class, 'activate'])->name('activate');
        Route::get('/delete/{id}', [DashboardController::class, 'delete'])->name('delete');
        Route::post('/fund/{id}', [DashboardController::class, 'fundUser'])->name('fund.user');
        Route::post('/approveFund/{id}', [DashboardController::class, 'approveFundUser'])->name('approveFund.user');
        Route::get('admin/message/user/{id}', [DashboardController::class, 'messageUser'])->name('message.user');
        Route::post('/fund/charge/all/{id}', [DashboardController::class, 'addChargeAirtimeUser'])->name('addChargeAirtime.user');
        Route::post('/send-message/{id}', [DashboardController::class, 'sendMessage'])->name('admin.sendMessage');
        Route::get('/walletSummary', [DashboardController::class, 'walletSummaryadmin'])->name('walletSummary');
        Route::get('/add/account', [DashboardController::class, 'add_account'])->name('add_account');
        Route::post('/new/account', [DashboardController::class, 'addnewAccount'])->name('admin.addnewAccount');
        Route::get('/marchant', [DashboardController::class, 'marchant'])->name('marchant');
        Route::get('/manageSubAdmin/{id}', [DashboardController::class, 'manageSubAdmin'])->name('manageSubAdmin');
        Route::post('/update-page-status/{id}/{action}', [DashboardController::class, 'updatePageStatus'])->name('updatePageStatus');

        Route::get('/admin/monnify-fee', [DashboardController::class, 'getMonnifyFee'])->name('admin.getMonnifyFee');

        Route::put('/adminedit/{id}', [DashboardController::class, 'adminupdates'])->name('adminupdates.profile');


        // // Merchant management
        // Route::resource('merchants', MerchantController::class);

        // // User management
        // Route::resource('users', UserController::class);
    });
});
