<?php

use App\Http\Controllers\airtimeController;
use App\Http\Controllers\authController;
use App\Http\Controllers\dataController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\settingController;
use App\Http\Controllers\transactionController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\utilitiesPaymentController;
use Illuminate\Support\Facades\Route;

Route::domain('{slug}.' . config('app.domain'))->middleware(['identify.merchant'])->group(function () {

    Route::get('/user/login', [authController::class, 'login'])->name('users.login');
    Route::get('/user/registration', [authController::class, 'registration'])->name('users.registration');
    Route::post('/user/login', [authController::class, 'loginAction'])->name('users.loginAction');
    Route::post('user/registration-action', [authController::class, 'registrationAction'])->name('users.registrationAction');

    Route::middleware(['auth:web'])->name('users.')->group(function () {
        // ... rest of the routes remain the same ...
// routes/transactions.

        Route::get('/dashboard', [usersController::class, 'dashboard'])->name('dashboard');
        Route::get('/transactions', [transactionController::class, 'calculateTransactions'])->name('usertransactions');
        Route::get('/airtime', [airtimeController::class, 'indexAction'])->name('airtime');
        Route::get('/data', [dataController::class, 'indexAction'])->name('data');
        Route::get('/electricity', [utilitiesPaymentController::class, 'indexElectricity'])->name('electricity');
        Route::get('/tv', [utilitiesPaymentController::class, 'indexTv'])->name('tv');
        Route::get('/upgradeTopuser', [utilitiesPaymentController::class, 'upgradeTopuser'])->name('upgradeTopuser');
        Route::get('/education', [utilitiesPaymentController::class, 'education'])->name('education');
        Route::get('/insurance', [utilitiesPaymentController::class, 'insurance'])->name('insurance');

        Route::get('/fetch-airtime-transactions', [transactionController::class, 'fetchAirtimeTransactions'])->name('fetch-airtime-transactions');
        Route::get('/fetch-data-transactions', [transactionController::class, 'fetchDataTransactions'])->name('fetch-data-transactions');
        Route::get('/fetch-data-transactions', [transactionController::class, 'fetchDataTransactions'])->name('fetch-data-transactions');
        Route::get('/fetch-electricity-transactions', [transactionController::class, 'fetchElectricityTransactions'])->name('fetch-electricity-transactions');
        Route::get('/fetch-tv-transactions', [transactionController::class, 'fetchTvTransactions'])->name('fetch-tv-transactions');
        Route::get('/fetch-education-transactions', [transactionController::class, 'fetchEducationTransactions'])->name('fetch-education-transactions');
        Route::get('/fetch-insurance-transactions', [transactionController::class, 'fetchInsuranceTransactions'])->name('fetch-insurance-transactions');
        Route::get('/fetch-fund-transactions', [TransactionController::class, 'fetchFundTransactions'])->name('fetch-fund-transactions');
        Route::get('/walletSummary', [transactionController::class, 'walletSummary'])->name('walletSummary');
#route setting
        Route::get('/usersetting', [settingController::class, 'usersetting'])->name('user.setting');
        Route::put('/usersedit/{id}', [settingController::class, 'update'])->name('update.profile');
#route logout
        Route::get('/logout', [logoutController::class, 'logout'])->name('logout');
#route notification
        Route::get('/usernotification', [transactionController::class, 'usernotification'])->name('usernotification');
#route support
        Route::get('/usersupport', [settingController::class, 'usersupport'])->name('usersupport');
        Route::post('/user/message', [settingController::class, 'sendMessage'])->name('user.message');
        Route::post('/user/email', [settingController::class, 'sendEmail'])->name('user.email');
#route message
        Route::post('/send-message', [settingController::class, 'send_message'])->name('message.send');
        Route::post('/send-email', [settingController::class, 'send_email'])->name('email.send');
#route setting
    });
});
