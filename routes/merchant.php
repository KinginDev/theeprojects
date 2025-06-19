<?php

use App\Http\Controllers\Merchant\AuthController;
use App\Http\Controllers\Merchant\DashboardController;
use Illuminate\Support\Facades\Route;

Route::domain('theeprojects.test')->prefix('merchant')->name('merchant.')->group(function () {
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
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('get-users/{merchantId}', [DashboardController::class, 'getMerchantUsers'])->name('users');
        Route::post('create/{merchantId}', [DashboardController::class, 'createUser'])->name('users.create');

        Route::get('/user/credit/account', [DashboardController::class, 'creditUserAccount'])->name('credit.user');
        Route::get('/add/fund/{userId}', [DashboardController::class, 'addFund'])->name('add.fund');
        Route::get('/approve/fund/{userId}', [DashboardController::class, 'approveFund'])->name('approve.fund');
        // add more routes here
    });
});
