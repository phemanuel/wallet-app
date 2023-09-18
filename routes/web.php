<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\CustomForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//----Auth routes--
Route::controller(AuthController::class)->group(function () {
    //----Login routes
    Route::get('/', 'home')->name('home');
    Route::get('login', 'login')->name('login');
    Route::post('login','loginAction')->name('login.action');
    
    //---setup account route
    Route::get('/account-setup', 'accountSetup')->name('account-setup');
    Route::post('account-setup-verify','accountSetupAction')->name('account-setup.action');
    //--------- Register routes
    //Route::get('/register', 'register')->name('register');
    Route::put('register/{id}','registerSave')->name('register.save'); 

    //--Logout route
    Route::get('logout', 'logout')->middleware('auth')->name('logout'); 
    
    //----profile route
    Route::get('profile', 'profile')->middleware('auth')->name('profile');
    Route::put('profile/{id}', 'profileUpdate')->middleware('auth')->name('profile-update');
    Route::get('profile-picture', 'profilePicture')->middleware('auth')->name('profile-picture');
    Route::post('profile-picture-update', 'profilePictureUpdate')->middleware('auth')->name('profile-picture-update');

});

//--Other pages route
Route::controller(PageController::class)->group(function () {
    //----contact route
    Route::get('contact', 'contact')->name('contact');   
    
});

    //-----User dashboard route
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
// Route::middleware('auth')->group(function () {
//     Route::get('user-pagination', [DashboardController::class, 'userPagination'])->name('user-pagination');
// });

//--------payment routes
   //-----User dashboard route
Route::middleware('auth')->group(function () {
    //----load wallet route
    Route::get('load-wallet', [PaymentController::class, 'index'])->name('load-wallet');
    //--payment save route
    Route::post('load-wallet-save', [PaymentController::class, 'loadPaymentSave'])
    ->name('load-wallet-payment-save');
    //----Flicks Api------------
    Route::post('flicks-pay', [PaymentController::class, 'flicksPay'])
    ->name('flicks-pay');
    //----payment response route
    Route::get('payment-response', [PaymentController::class, 'paymentResponse'])->name('payment-response');
    //----load wallet payment page route
    Route::get('load-wallet-payment-page', [PaymentController::class, 'loadPaymentPage'])
    ->name('load-wallet-payment-page');
    // Transaction successful route
    Route::get('transaction-successful/{transaction_id}', [PaymentController::class, 'transactionSuccessful'])
    ->name('transaction_successful');
    // Transaction failed route
    Route::get('transaction-failed/{transaction_id}', [PaymentController::class, 'transactionFailed'])
    ->name('transaction_failed');
    //---pay from wallet route
    Route::get('pay-wallet', [PaymentController::class, 'payWallet'])->name('pay-wallet');
    //----transfer from wallet route
    Route::get('pay-other-wallet', [PaymentController::class, 'payOtherWallet'])->name('pay-other-wallet');
    //----Verify wallet id route
    Route::post('pay-other-wallet-verify', [PaymentController::class, 'payOtherWalletAction'])
    ->name('pay-other-wallet-action');
    //----Save fund transfer transaction route
    Route::post('pay-other-wallet-save', [PaymentController::class, 'payOtherWalletSave'])
    ->name('pay-other-wallet-save');
    //---bank refund route
    Route::get('refund-bank', [PaymentController::class, 'refundBank'])->name('refund-bank');
    //---Fund wallet transaction history
    Route::get('transaction-history', [PaymentController::class, 'transactionHistory'])->name('transaction-history');
    //---Fund transfer transaction history
    Route::get('fund-transfer-history', [PaymentController::class, 'fundTransferHistory'])->name('fund-transfer-history');
    //---Fund recieved transaction history
    Route::get('fund-recieved-history', [PaymentController::class, 'fundRecievedHistory'])->name('fund-recieved-history');
    //---requery transaction route
    Route::get('requery-transaction/{id}', [PaymentController::class, 'requeryTransaction'])
    ->name('requery-transaction');
    //---payment from wallet (acceptance) route-----
    Route::get('pay-wallet-acceptance/{totalFee}', [PaymentController::class, 'payWalletAcceptance'])
    ->name('pay-wallet-acceptance');
    //---payment from wallet (acceptance) route-----
    Route::get('pay-wallet-acceptance-view', [PaymentController::class, 'payWalletAcceptanceView'])
    ->name('pay-wallet-acceptance-view');
    //----pay from wallet (acceptance) save route
    Route::post('pay-wallet-acceptance-action', [PaymentController::class, 'payWalletAcceptanceAction'])
    ->name('pay-wallet-acceptance-action');
    //---payment from wallet (Schoolfee) route-----
    Route::get('pay-wallet-school-fee/{totalFee}', [PaymentController::class, 'payWalletSchoolFee'])
    ->name('pay-wallet-school-fee');
    //---payment from wallet (schoolfee) route-----
    Route::get('pay-wallet-school-fee-view', [PaymentController::class, 'payWalletSchoolFeeView'])
    ->name('pay-wallet-school-fee-view');
    //----pay from wallet (schoolfee) save route
    Route::post('pay-wallet-school-fee-action', [PaymentController::class, 'payWalletSchoolFeeAction'])
    ->name('pay-wallet-school-fee-action');
    //---payment from wallet (schoolfee-all payment) route-----
    Route::get('handle-all-payment', [PaymentController::class, 'handleAllPayment'])
    ->name('handle-all-payment');
    //---payment from wallet (Deptfee) route-----
    Route::get('pay-wallet-dept-fee/{totalFee}', [PaymentController::class, 'payWalletDeptFee'])
    ->name('pay-wallet-dept-fee');
    //---payment from wallet (deptfee) route-----
    Route::get('pay-wallet-dept-fee-view', [PaymentController::class, 'payWalletDeptFeeView'])
    ->name('pay-wallet-dept-fee-view');
    //----pay from wallet (Deptfee) save route
    Route::get('pay-wallet-dept-fee-action/{payid}', [PaymentController::class, 'payWalletDeptFeeAction'])
    ->name('pay-wallet-dept-fee-action');
    
});

//----send mail route
Route::get('send-mail', [MailController::class, 'index'])->name('send-mail');
//----successful transaction route--
Route::get('send-mail-success/{transaction_id}', [MailController::class, 'mailSuccess'])->name('send-mail-success');
//----failed transaction route--
Route::get('send-mail-failed/{transaction_id}', [MailController::class, 'mailFailed'])->name('send-mail-failed');
//----send mail(fund transfer) route
Route::get('send-mail-fund-transfer', [MailController::class, 'mailFundTransfer'])->name('send-mail-fund-transfer');
//----send mail(pay from wallet) route
Route::get('send-mail-pay-wallet', [MailController::class, 'mailPayWallet'])->name('send-mail-pay-wallet');

//---Api Route
//     Route::get('api/user', [ApiController::class, 'fetchApiData'])->name('api.user');
//     Route::post('/api-data', [ApiController::class, 'processApiData'])->name('api-data');

//------Reset Password Route
Route::get('/forgot-password', function () {
    return view('auth.user-forgot-password');
})->middleware('guest')->name('password.request');
Route::post('/forgot-password', [CustomForgotPasswordController::class, 'forgotPassword'])
    ->middleware('guest')
    ->name('password.email');
Route::get('/reset-password/{token}/{email}', function ($token,$email) {
    return view('auth.user-reset-password', ['token' => $token , 'email' => $email]);
})->middleware('guest')->name('password.reset');
Route::post('/reset-password', [CustomForgotPasswordController::class, 'resetPassword'])
    ->middleware('guest')
    ->name('password.update');

