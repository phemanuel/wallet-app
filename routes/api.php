<?php

use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('user', UserController ::class);
Route::apiResource('payment', PaymentController ::class); 
Route::get('wallet-view/{walletid}', [PaymentController::class, 'walletView'])
    ->name('wallet-view');
Route::get('wallet-pay/{transaction_id}', [PaymentController::class, 'walletPay'])
    ->name('wallet-pay');   
    Route::get('wallet', [PaymentController::class, 'walletPage'])
    ->name('wallet');   

// Route::prefix('v1')->name('api.v1.')->namespace('Api\V1')->group(function(){
//     Route::get('/status', function() {
//         return response()->json(['status' =>'success']);
//     })->name('status');       
    
// });

// Route::prefix('v2')->group(function(){
//     Route::get('/status', function() {
//         return response()->json(['status' => true]);
//     });    
// });



