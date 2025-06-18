<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\authController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('template-layout.index');
});
Route::get('/login', [authController::class, 'login'])->name('login');
Route::post('/login-action', [authController::class, 'loginAction'])->name('loginAction');
Route::get('/registration', [authController::class, 'registration'])->name('registration');
Route::post('/registration-action', [authController::class, 'registrationAction'])->name('registrationAction');
Route::get('/forget_password', [authController::class, 'forget_password'])->name('forget_password');
Route::post('/forgetPassword', [authController::class, 'forgetPasswordMail'])->name('forgetPassword');
Route::get('/password/reset/{token}', [authController::class, 'showResetForm'])->name('password.reset');
Route::post('/update-password', [authController::class, 'updatePassword'])->name('updatePassword');
Route::get('/logout', [authController::class, 'logout'])->name('logout');

Route::middleware(['auth:admin'])->group(function () {
#admin routes
    Route::get('/admin/dashboard', [adminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [adminController::class, 'manage'])->name('manage');
    Route::get('/admin/users/credit/account', [adminController::class, 'creditUserAccount'])->name('creditUserAccount');
    Route::get('/admin/airtime', [adminController::class, 'adminAirtime'])->name('adminAirtime');
    Route::get('/admin/data', [adminController::class, 'adminData'])->name('adminData');
    Route::get('/admin/electricity', [adminController::class, 'adminElectricity'])->name('adminElectricity');
    Route::get('/admin/tv', [adminController::class, 'adminTv'])->name('adminTv');
    Route::get('/admin/education', [adminController::class, 'adminEducation'])->name('adminEducation');
    Route::get('/admin/insurance', [adminController::class, 'adminInsurance'])->name('adminInsurance');
    Route::get('/admin/message', [adminController::class, 'message'])->name('message');
    Route::get('/admin/notification', [adminController::class, 'notification'])->name('notification');
    Route::get('/admin/site_setting', [adminController::class, 'site_setting'])->name('site_setting');
    Route::get('/admin/edit_profile', [adminController::class, 'edit_profile'])->name('edit_profile');
    Route::get('/admin/add/charge/{id}', [adminController::class, 'addCharge'])->name('add.charge');
    Route::get('/admin/edit/user/{id}', [adminController::class, 'editUser'])->name('edit.user');
    Route::get('/admin/add/fund/{id}', [adminController::class, 'addFund'])->name('add.fund');
    Route::get('/admin/approve/fund/{id}', [adminController::class, 'approveFund'])->name('approve.fund');
    Route::post('/admin/update/user/{id}', [adminController::class, 'updateUser'])->name('update.user');
    Route::get('/admin/deactivate/{id}', [adminController::class, 'deactivate'])->name('deactivate');
    Route::get('/admin/activate/{id}', [adminController::class, 'activate'])->name('activate');
    Route::get('/admin/delete/{id}', [adminController::class, 'delete'])->name('delete');
    Route::post('/admin/fund/{id}', [adminController::class, 'fundUser'])->name('fund.user');
    Route::post('/admin/approveFund/{id}', [adminController::class, 'approveFundUser'])->name('approveFund.user');
    Route::get('admin/message/user/{id}', [adminController::class, 'messageUser'])->name('message.user');
    Route::post('/admin/fund/charge/all/{id}', [adminController::class, 'addChargeAirtimeUser'])->name('addChargeAirtime.user');
    Route::post('/admin/send-message/{id}', [adminController::class, 'sendMessage'])->name('admin.sendMessage');
    Route::get('/admin/walletSummary', [adminController::class, 'walletSummaryadmin'])->name('walletSummary.admin');
    Route::get('/admin/add/account', [adminController::class, 'add_account'])->name('add_account');
    Route::post('/admin/new/account', [adminController::class, 'addnewAccount'])->name('admin.addnewAccount');
    Route::get('/admin/marchant', [adminController::class, 'marchant'])->name('marchant');
    Route::get('/admin/manageSubAdmin/{id}', [adminController::class, 'manageSubAdmin'])->name('manageSubAdmin');
    Route::post('/admin/update-page-status/{id}/{action}', [adminController::class, 'updatePageStatus'])->name('updatePageStatus');

#end admin routes

    Route::put('/settings-update', [adminController::class, 'updateSetting'])->name('settings.update');
    Route::put('/adminedit/{id}', [adminController::class, 'adminupdates'])->name('adminupdates.profile');

// Route::post('/user/top-up', [utilitiesPaymentController::class, 'topUp'])->name('userTopUp');

// Route to update the fee dynamically
    Route::post('/admin/fee-config', [adminController::class, 'updateFee'])->name('admin.updateFee');

// API endpoint to get the current Monnify fee
    Route::get('/admin/monnify-fee', [adminController::class, 'getMonnifyFee'])->name('admin.getMonnifyFee');
});
