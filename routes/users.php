<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\User\TvController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\DataController;
use App\Http\Controllers\AllPaymentController;
use App\Http\Controllers\User\AirtimeController;
use App\Http\Controllers\User\SettingController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\EducationController;
use App\Http\Controllers\User\ElectricityController;
use App\Http\Controllers\User\TransactionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\User\UtilitiesPaymentController;


Route::middleware(['identify.merchant','require.merchant'])->group(function () {
    // Handle custom domains
    Route::group([], function () {

    Route::get('/', [PageController::class, 'index'])->name('merchant.home');
     Route::get('page/{slug}', [PageController::class, 'show'])->name('merchant.page.show');

    Route::prefix('user')->name('users.')->group(function () {
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::get('/registration', [AuthController::class, 'registration'])->name('registration');
        Route::post('/login', [AuthController::class, 'loginAction'])->name('loginAction');
        Route::post('/registration-action', [AuthController::class, 'registrationAction'])->name('registrationAction');
        Route::get('/forget_password', [AuthController::class, 'forget_password'])->name('show.password');
        Route::post('/forgetPassword', [AuthController::class, 'forgetPasswordMail'])->name('forget.password');
        Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
        Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('update.password');

          Route::get('/email/verify', fn() => view('users-layout.auth.verify'))->name('verification.notice');
            Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
                $request->fulfill();
                return redirect('/user/dashboard');
            })->middleware(['signed'])->name('verification.verify');
            Route::post('/email/verification-notification', [AuthController::class, 'sendVerificationEmail'])->name('verification.send');

            // ... rest of the routes remain the same ...
            // routes/transactions.
            Route::post('/make/payment', [AllPaymentController::class, 'makePayment'])->name('make.payment');
            Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
            Route::get('/transactions', [TransactionController::class, 'calculateTransactions'])->name('usertransactions');


            Route::get('/data', [DataController::class, 'indexAction'])->name('data');
            Route::get('/network/plans', [DataController::class, 'getNetworkPlans'])->name('data.network.plans');
            Route::post('/data/purchase', [DataController::class, 'purchaseData'])->name('data.purchase');
            Route::post('/data/purchase/data', [DataController::class, 'dataPurchaseMtnAirtelGifting'])->name('data.purchase.mtn.airtel.data');
            Route::get('/network/get/plans', [DataController::class, 'dataMtnAirtelGifting'])->name('data.mtn.airtel.gifting');

            Route::get('/electricity', [UtilitiesPaymentController::class, 'indexElectricity'])->name('electricity');
            Route::get('/tv', [UtilitiesPaymentController::class, 'indexTv'])->name('tv');
            Route::get('/upgradeTopuser', [UtilitiesPaymentController::class, 'upgradeTopuser'])->name('upgradeTopuser');

            Route::prefix('/education')->group(function () {
                Route::get('/', [UtilitiesPaymentController::class, 'education'])->name('education');
                Route::post('/purchase', [UtilitiesPaymentController::class, 'purchaseEducation'])->name('education.purchase');
                Route::post('/verify', [EducationController::class, 'verifyEducation'])->name('education.verify');
                Route::post('/check-result', [UtilitiesPaymentController::class, 'checkEducationResult'])->name('education.check.result');
                Route::post('/query-transaction', [UtilitiesPaymentController::class, 'queryEducationTransaction'])->name('education.query.transaction');
            });

            Route::get('/insurance', [UtilitiesPaymentController::class, 'insurance'])->name('insurance');




            Route::get('/fetch-airtime-transactions', [TransactionController::class, 'fetchAirtimeTransactions'])->name('fetch-airtime-transactions');
            Route::get('/fetch-data-transactions', [TransactionController::class, 'fetchDataTransactions'])->name('fetch-data-transactions');
            Route::get('/fetch-data-transactions', [TransactionController::class, 'fetchDataTransactions'])->name('fetch-data-transactions');
            Route::get('/fetch-electricity-transactions', [TransactionController::class, 'fetchElectricityTransactions'])->name('fetch-electricity-transactions');
            Route::get('/fetch-tv-transactions', [TransactionController::class, 'fetchTvTransactions'])->name('fetch-tv-transactions');
            Route::get('/fetch-education-transactions', [TransactionController::class, 'fetchEducationTransactions'])->name('fetch-education-transactions');
            Route::get('/fetch-insurance-transactions', [TransactionController::class, 'fetchInsuranceTransactions'])->name('fetch-insurance-transactions');
            Route::get('/fetch-fund-transactions', [TransactionController::class, 'fetchFundTransactions'])->name('fetch-fund-transactions');
            Route::get('/walletSummary', [TransactionController::class, 'walletSummary'])->name('walletSummary');

            Route::get('/usersetting', [SettingController::class, 'usersetting'])->name('user.setting');
            Route::put('/usersedit/{id}', [SettingController::class, 'update'])->name('update.profile');

            Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/usernotification', [TransactionController::class, 'usernotification'])->name('usernotification');

            Route::get('/usersupport', [SettingController::class, 'usersupport'])->name('usersupport');
            Route::post('/user/message', [SettingController::class, 'sendMessage'])->name('user.message');
            Route::post('/user/email', [SettingController::class, 'sendEmail'])->name('user.email');


            Route::post('/send-message', [SettingController::class, 'send_message'])->name('message.send');
            Route::post('/send-email', [SettingController::class, 'send_email'])->name('email.send');




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

            Route::prefix('tv')->group(function () {
                Route::get('/', [TvController::class, 'indexTv'])->name('tv');
                Route::post('/purchase', [TvController::class, 'purchaseRenewBouquet'])->name('tv.purchase');
                Route::post('/verify', [TvController::class, 'verifySmartCardNumber'])->name('tv.verify');
            });

        });


    });
});

