<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\SubscriptionController;
use App\Http\Controllers\User\UserAccountController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function (){

    Route::post('login', [AuthController::class, 'login']);

    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::get('user', [AuthController::class, 'authUser']);

    Route::post('user/register', [UserAccountController::class, 'registerUser']);

    Route::put('update/{user}/user/account', [UserAccountController::class, 'updateAccount']);

    Route::patch('change/password', [AuthController::class, 'changePassword']);

    Route::post('send/password-reset/request', [AuthController::class, 'sendResetMail']);

    Route::post('reset/password', [AuthController::class, 'resetPassword']);

    Route::post('verify/email', [AuthController::class, 'verifyEmail']);
});

#------------------------------------------- Service and Subscription Routes ---------------

Route::get('fetch/agencies', [SubscriptionController::class, 'fetchAgencies']);

Route::post('/service/subscribe', [SubscriptionController::class, 'subscribeForService']);

Route::post('request/service', [SubscriptionController::class, 'serviceRequest']);

#------------------------------------------- End  ------------------------------------------

#------------------------------------------- Transactions ------------------------------------

Route::get('fetch/transactions', [PaymentController::class, 'viewTransactions']);

Route::post('payment/callback', [PaymentController::class, 'paymentCallback']);

#------------------------------------------- Transactions ------------------------------------
