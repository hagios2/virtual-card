<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AgencyAccountController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\UserAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;



Route::prefix('auth')->group(function (){

    Route::post('login', [AuthController::class, 'login']);

    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::get('user', [AuthController::class, 'authUser']);

    Route::patch('change/password', [AuthController::class, 'changePassword']);

    Route::post('send/password-reset/request', [AuthController::class, 'sendResetMail']);

    Route::post('reset/password', [AuthController::class, 'reset']);
});

#---------------------------- Super Admin Routes ------------------------------------------------------

Route::post('create', [AdminController::class, 'createAdmin']);

Route::get('fetch/admins', [AdminController::class, 'fetchAdmins']);

Route::get('{admin}/fetch/', [AdminController::class, 'fetchAnAdmin']);

Route::put('{admin}/update', [AdminController::class, 'updateAdmin']);

Route::patch('deactivate/{admin}/account', [AdminController::class, 'blockAdmin']);

Route::patch('activate/{admin}/account', [AdminController::class, 'unBlockAdmin']);

Route::get('fetch/user/accounts', [UserAccountController::class, 'fetchUsers']);

Route::post('create/user/account', [UserAccountController::class, 'registerUser']);

Route::get('fetch/{user}/user-account', [UserAccountController::class, 'fetchUser']);

Route::put('update/{user}/user-account', [UserAccountController::class, 'updateUser']);

Route::patch('deactivate/{user}/user-account', [UserAccountController::class, 'blockUser']);

Route::patch('activate/{user}/user-account', [UserAccountController::class, 'unBlockUser']);

Route::post('create/agency/account', [AgencyAccountController::class, 'registerAgency']);

Route::get('fetch/agency/accounts', [AgencyAccountController::class, 'fetchAgencies']);

Route::get('fetch/{agency}/agency-account', [AgencyAccountController::class, 'fetchAgency']);

Route::put('update/{agency}/agency-account', [AgencyAccountController::class, 'updateAccount']);

Route::patch('deactivate/{agency}/agency-account', [AgencyAccountController::class, 'blockAgency']);

Route::patch('activate/{agency}/agency-account', [AgencyAccountController::class, 'unBlockAgency']);

Route::patch('deactivate/{agent}/agent-account', [AgencyAccountController::class, 'blockAgent']);

Route::patch('activate/{agent}/agent-account', [AgencyAccountController::class, 'unBlockAgent']);

#---------------------------- End Super Admin Routes --------------------------------------------------------------


#------------------------------------------- Transactions ------------------------------------

Route::get('fetch/transactions', [PaymentController::class, 'viewTransactions']);
#------------------------------------------- Transactions ------------------------------------
