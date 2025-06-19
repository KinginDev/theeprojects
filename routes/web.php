<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\authController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [authController::class, 'login'])->name('login');
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
