<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AllPaymentController;
use App\Http\Controllers\authController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::domain(config('app.domain'))->group(function () {
    Route::get('/logout', [authController::class, 'logout'])->name('logout');
    Route::any('/webhook/process', [AllPaymentController::class, 'processWebhook'])->name('webhook.process');

    Route::middleware('guest:web')->group(function () {
        Route::get('/', function () {
            return view('template-layout.index');
        });
        Route::get('/home', function () {
            return view('welcome');
        })->name('home');
    });



    // Route::middleware('auth')->group(function () {
    Route::any('/process/callback', [AllPaymentController::class, 'processCallback'])->name('process.callback');

    // });

    Route::middleware(['auth:admin'])->group(function () {
    #admin routes
    Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

    #end admin routes

    Route::put('/settings-update', [DashboardController::class, 'updateSetting'])->name('settings.update');

    // Route::post('/user/top-up', [UtilitiesPaymentController::class, 'topUp'])->name('userTopUp');

    // Route to update the fee dynamically
    Route::post('/admin/fee-config', [DashboardController::class, 'updateFee'])->name('admin.updateFee');

    // API endpoint to get the current Monnify fee
    Route::get('/admin/monnify-fee', [DashboardController::class, 'getMonnifyFee'])->name('admin.getMonnifyFee');
    });

    Route::middleware(['auth:web', 'verified'])->group(function () {
        // Protected user routes that require email verification
        Route::get('/dashboard', function () {
            return view('users-layout.dashboard');
        })->name('users.dashboard');
    });

    Route::middleware(['auth:merchant', 'verified'])->group(function () {
        // Protected merchant routes that require email verification
        Route::get('/merchant/dashboard', function () {
            return view('merchant-layout.dashboard');
        })->name('merchant.dashboard');
    });
});
