<?php

use App\Http\Controllers\airtimeController;
use App\Http\Controllers\allPaymentController;
use App\Http\Controllers\authController;
use App\Http\Controllers\dataController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\settingController;
use App\Http\Controllers\transactionController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\utilitiesPaymentController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:web')->group(function () {
    #GENERAL auth routes, will change to a differnt login flow later
    Route::get('/login', [authController::class, 'login'])->name('login');
    Route::post('/login', [authController::class, 'loginAction'])->name('loginAction');
    Route::get('/registration', [authController::class, 'registration'])->name('registration');
    Route::post('/registration-action', [authController::class, 'registrationAction'])->name('registrationAction');
    Route::get('/forget_password', [authController::class, 'forget_password'])->name('forget_password');
    Route::post('/forgetPassword', [authController::class, 'forgetPasswordMail'])->name('forgetPassword');
    Route::get('/password/reset/{token}', [authController::class, 'showResetForm'])->name('password.reset');
    Route::post('/update-password', [authController::class, 'updatePassword'])->name('updatePassword');
    Route::get('/logout', [authController::class, 'logout'])->name('logout');
});

Route::domain('{slug}.theeprojects.test')->middleware(['identify.merchant'])->group(function () {
    Route::get('/', function () {
        return view('template-layout.index');
    });

    Route::get('/user/login', [authController::class, 'login'])->name('users.login');
    Route::get('/user/registration', [authController::class, 'registration'])->name('users.registration');
    Route::post('user/registration-action', [authController::class, 'registrationAction'])->name('users.registrationAction');

    Route::middleware(['auth:web'])->name('users.')->group(function () {

        Route::get('/dashboard', [usersController::class, 'dashboard'])->name('dashboard');

        Route::post('/calculate-transactions', [usersController::class, 'calculateTransactions'])->name('calculateTransactions');
        Route::get('/airtime', [airtimeController::class, 'indexAction'])->name('airtime');
        Route::post('/airtime/purchase', [airtimeController::class, 'purchaseAirtime'])->name('airtime.purchase');
        Route::get('/transactionview', [transactionController::class, 'indexAction'])->name('transaction');
        Route::get('/data', [dataController::class, 'indexAction'])->name('data');
        Route::post('/data/purchase', [dataController::class, 'purchaseData'])->name('data.purchase');
        Route::get('/api/network/plans', [dataController::class, 'getNetworkPlans'])->name('getNetworkPlans');
        Route::get('/electricity', [utilitiesPaymentController::class, 'indexElectricity'])->name('electricity');
        Route::post('/tv/billcode/electricity', [utilitiesPaymentController::class, 'meterCodeVerify'])->name('meterCodeVerify');
        Route::post('/electricity/purchase', [utilitiesPaymentController::class, 'purchaseElectricity'])->name('electricity.purchase');
        Route::get('/tv', [utilitiesPaymentController::class, 'indexTv'])->name('tv');
        Route::post('/tv/billcode/Gotv', [utilitiesPaymentController::class, 'billCodeGotv'])->name('tv.billcode');
        Route::post('/tv/billcode/Dstv', [utilitiesPaymentController::class, 'billCodeDstv'])->name('tv.billcode');
        Route::post('/tv/billcode/Startime', [utilitiesPaymentController::class, 'billCodeStartime'])->name('tv.billcode');
        Route::post('/tv/billcode/Showmax', [utilitiesPaymentController::class, 'billCodeShowmax'])->name('tv.billcode');
        Route::post('/tv/changeBouquet', [utilitiesPaymentController::class, 'changeBouquet'])->name('tv.changeBouquet');
        Route::post('/tv/renewBouquet', [utilitiesPaymentController::class, 'renewBouquet'])->name('tv.renewBouquet');
        Route::post('/tv/bouquet/Startime', [utilitiesPaymentController::class, 'bouquetStartime'])->name('tv.bouquet');
        Route::post('/tv/bouquet/Showmax', [utilitiesPaymentController::class, 'bouquetShowmax'])->name('tv.bouquet');
        Route::post('/fund/monnify', [allPaymentController::class, 'initializeMonnify'])->name('initializeMonnify');
        Route::post('/user/fundmanual', [allPaymentController::class, 'manualFunding'])->name('manualFunding');

        Route::post('/upgradeTopuser', [utilitiesPaymentController::class, 'upgradeTopuser'])->name('upgradeTopuser');
        Route::get('/education', [utilitiesPaymentController::class, 'education'])->name('education');
        Route::post('/waec/check-details', [utilitiesPaymentController::class, 'waec_check_details'])->name('waec_check_details');
        Route::post('/waec/check-result', [utilitiesPaymentController::class, 'waec_check_result'])->name('waec_check_result');
        Route::get('/success', [utilitiesPaymentController::class, 'success'])->name('success');
        Route::post('/jamb/verify', [utilitiesPaymentController::class, 'jamb_verify'])->name('jamb_verify');
        Route::post('/jamb/register', [utilitiesPaymentController::class, 'jamb_register'])->name('jamb_register');
        Route::get('/insurance', [utilitiesPaymentController::class, 'insurance'])->name('insurance');
        Route::post('/insurance/ui_insure', [utilitiesPaymentController::class, 'ui_insure'])->name('ui_insure');
        Route::post('/insurance/healthInsurance', [utilitiesPaymentController::class, 'healthInsurance'])->name('healthInsurance');
        Route::post('/data/purchase/data', [dataController::class, 'dataPurchaseMtnAirtelGifting'])->name('data.purchase.mtn.airtel.data');
        Route::get('/api/network/get/plans', [dataController::class, 'dataMtnAirtelGifting'])->name('data.mtn.airtel.gifting');
        Route::get('/usertransactions', [transactionController::class, 'usertransactions'])->name('usertransactions');
// routes/transactions.
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
        Route::put('/usersedit/{id}', [settingController::class, 'update'])->name('users.update.profile');
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
