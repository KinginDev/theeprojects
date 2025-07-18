<?php

use App\Classes\Helper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\dataController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\AirtimeController;
use App\Http\Controllers\settingController;
use App\Http\Controllers\allPaymentController;
use App\Http\Controllers\ElectricityController;
use App\Http\Controllers\transactionController;
use App\Http\Controllers\UtilitiesPaymentController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


Route::middleware(['identify.merchant','require.merchant'])->group(function () {
    // Handle custom domains
    Route::group([], function () {

    Route::get('/', [PageController::class, 'index'])->name('merchant.home');
     Route::get('page/{slug}', [PageController::class, 'show'])->name('merchant.page.show');

    Route::prefix('user')->name('users.')->group(function () {
        Route::get('/login', [authController::class, 'login'])->name('login');
        Route::get('/registration', [authController::class, 'registration'])->name('registration');
        Route::post('/login', [authController::class, 'loginAction'])->name('loginAction');
        Route::post('/registration-action', [authController::class, 'registrationAction'])->name('registrationAction');
        Route::get('/forget_password', [authController::class, 'forget_password'])->name('show.password');
        Route::post('/forgetPassword', [authController::class, 'forgetPasswordMail'])->name('forget.password');
        Route::get('/password/reset/{token}', [authController::class, 'showResetForm'])->name('password.reset');
        Route::post('/update-password', [authController::class, 'updatePassword'])->name('update.password');

          Route::get('/email/verify', fn() => view('users-layout.auth.verify'))->name('verification.notice');
            Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
                $request->fulfill();
                return redirect('/user/dashboard');
            })->middleware(['signed'])->name('verification.verify');
            Route::post('/email/verification-notification', [authController::class, 'sendVerificationEmail'])->name('verification.send');

            // ... rest of the routes remain the same ...
            // routes/transactions.
            Route::post('/make/payment', [allPaymentController::class, 'makePayment'])->name('make.payment');
            Route::get('/dashboard', [usersController::class, 'dashboard'])->name('dashboard');
            Route::get('/transactions', [transactionController::class, 'calculateTransactions'])->name('usertransactions');


            Route::get('/data', [dataController::class, 'indexAction'])->name('data');
            Route::get('/network/plans', [dataController::class, 'getNetworkPlans'])->name('data.network.plans');
            Route::post('/data/purchase', [dataController::class, 'purchaseData'])->name('data.purchase');
            Route::post('/data/purchase/data', [dataController::class, 'dataPurchaseMtnAirtelGifting'])->name('data.purchase.mtn.airtel.data');
            Route::get('/network/get/plans', [dataController::class, 'dataMtnAirtelGifting'])->name('data.mtn.airtel.gifting');

            Route::get('/electricity', [UtilitiesPaymentController::class, 'indexElectricity'])->name('electricity');
            Route::get('/tv', [UtilitiesPaymentController::class, 'indexTv'])->name('tv');
            Route::get('/upgradeTopuser', [UtilitiesPaymentController::class, 'upgradeTopuser'])->name('upgradeTopuser');
            Route::get('/education', [UtilitiesPaymentController::class, 'education'])->name('education');
            Route::get('/insurance', [UtilitiesPaymentController::class, 'insurance'])->name('insurance');




            Route::get('/fetch-airtime-transactions', [transactionController::class, 'fetchAirtimeTransactions'])->name('fetch-airtime-transactions');
            Route::get('/fetch-data-transactions', [transactionController::class, 'fetchDataTransactions'])->name('fetch-data-transactions');
            Route::get('/fetch-data-transactions', [transactionController::class, 'fetchDataTransactions'])->name('fetch-data-transactions');
            Route::get('/fetch-electricity-transactions', [transactionController::class, 'fetchElectricityTransactions'])->name('fetch-electricity-transactions');
            Route::get('/fetch-tv-transactions', [transactionController::class, 'fetchTvTransactions'])->name('fetch-tv-transactions');
            Route::get('/fetch-education-transactions', [transactionController::class, 'fetchEducationTransactions'])->name('fetch-education-transactions');
            Route::get('/fetch-insurance-transactions', [transactionController::class, 'fetchInsuranceTransactions'])->name('fetch-insurance-transactions');
            Route::get('/fetch-fund-transactions', [TransactionController::class, 'fetchFundTransactions'])->name('fetch-fund-transactions');
            Route::get('/walletSummary', [transactionController::class, 'walletSummary'])->name('walletSummary');


            Route::get('/usersetting', [settingController::class, 'usersetting'])->name('user.setting');
            Route::put('/usersedit/{id}', [settingController::class, 'update'])->name('update.profile');


            Route::get('/logout', [logoutController::class, 'logout'])->name('logout');


            Route::get('/usernotification', [transactionController::class, 'usernotification'])->name('usernotification');


            Route::get('/usersupport', [settingController::class, 'usersupport'])->name('usersupport');
            Route::post('/user/message', [settingController::class, 'sendMessage'])->name('user.message');
            Route::post('/user/email', [settingController::class, 'sendEmail'])->name('user.email');


            Route::post('/send-message', [settingController::class, 'send_message'])->name('message.send');
            Route::post('/send-email', [settingController::class, 'send_email'])->name('email.send');




            Route::prefix('airtime')->group(function () {
                Route::get('/', [AirtimeController::class, 'indexAction'])->name('airtime');
                Route::post('/purchase', [AirtimeController::class, 'purchaseAirtime'])->name('airtime.purchase');
            });

            Route::prefix('electricity')->group(function () {
                Route::get('/', [ElectricityController::class, 'indexElectricity'])->name('electricity');
                Route::post('/verify-meter', [ElectricityController::class, 'verifyMeterNumber'])->name('electricity.verifyMeter');
                Route::post('/purchase', [ElectricityController::class, 'purchaseElectricity'])->name('electricity.purchase');
                Route::post('verify/meter', [ElectricityController::class, 'meterCodeVerify'])->name('meterCodeVerify');
            });

        });


    });
});

