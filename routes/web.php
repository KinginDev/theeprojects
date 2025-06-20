<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\authController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:web')->group(function () {
    #GENERAL auth routes, will change to a differnt login flow later
    Route::get('/login', function () {
        return view('welcome');
    })->name('login');
    Route::post('/login', [authController::class, 'loginAction'])->name('loginAction');
    Route::get('/registration', [authController::class, 'registration'])->name('registration');
    Route::post('/registration-action', [authController::class, 'registrationAction'])->name('registrationAction');
    Route::get('/forget_password', [authController::class, 'forget_password'])->name('forget_password');
    Route::post('/forgetPassword', [authController::class, 'forgetPasswordMail'])->name('forgetPassword');
    Route::get('/password/reset/{token}', [authController::class, 'showResetForm'])->name('password.reset');
    Route::post('/update-password', [authController::class, 'updatePassword'])->name('updatePassword');
    Route::get('/logout', [authController::class, 'logout'])->name('logout');
});

Route::middleware(['auth:admin'])->group(function () {
#admin routes
    Route::get('/admin/dashboard', [adminController::class, 'dashboard'])->name('admin.dashboard');

#end admin routes

    Route::put('/settings-update', [adminController::class, 'updateSetting'])->name('settings.update');
    Route::put('/adminedit/{id}', [adminController::class, 'adminupdates'])->name('adminupdates.profile');

// Route::post('/user/top-up', [utilitiesPaymentController::class, 'topUp'])->name('userTopUp');

// Route to update the fee dynamically
    Route::post('/admin/fee-config', [adminController::class, 'updateFee'])->name('admin.updateFee');

// API endpoint to get the current Monnify fee
    Route::get('/admin/monnify-fee', [adminController::class, 'getMonnifyFee'])->name('admin.getMonnifyFee');
});
