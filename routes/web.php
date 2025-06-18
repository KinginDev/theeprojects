<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\airtimeController;
use App\Http\Controllers\transactionController;
use App\Http\Controllers\dataController;
use App\Http\Controllers\utilitiesPaymentController;
use App\Http\Controllers\allPaymentController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\settingController;
use App\Http\Controllers\logoutController;




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

Route::middleware(['auth'])->group(function () {
Route::get('/dashboard', [usersController::class, 'dashboard'])->name('dashboard');
Route::get('/admin/generate-user-emails-csv', [usersController::class, 'generateUserEmailsCSV'])->name('admin.generateUserEmailsCSV');

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
Route::put('/settings-update', [adminController::class, 'updateSetting'])->name('settings.update');
Route::put('/adminedit/{id}', [adminController::class, 'adminupdates'])->name('adminupdates.profile');

// Route::post('/user/top-up', [utilitiesPaymentController::class, 'topUp'])->name('userTopUp');


// Route to update the fee dynamically
Route::post('/admin/fee-config', [adminController::class, 'updateFee'])->name('admin.updateFee');

// API endpoint to get the current Monnify fee
Route::get('/admin/monnify-fee', [adminController::class, 'getMonnifyFee'])->name('admin.getMonnifyFee');
});
