<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserAccountController;
use App\Services\AdminManageUserAccountService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\PasswordResetController;



Route::prefix('auth')->group(function (){

    Route::post('login', [AuthController::class, 'login']);

    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::get('user', [AuthController::class, 'user']);

    Route::post('change/password', [PasswordResetController::class, 'changeUserPassword']);

    Route::post('send/password-reset/request', [PasswordResetController::class, 'sendResetMail']);

    Route::post('reset/password', [PasswordResetController::class, 'reset']);
});

#---------------------------- Super Admin Routes ------------------------------------------------------

Route::post('add/admin', [AdminController::class, 'createAmin']);

Route::get('fetch/admins', [AdminController::class, 'fetchAnAdmin']);

Route::get('fetch/{admin}/admin', [AdminController::class, 'fetchAnAdmin']);

Route::patch('deactivate/{admin}/admin-account', [AdminController::class, 'blockAdmin']);

Route::patch('activate/{admin}/admin-account', [AdminController::class, 'unBlockAdmin']);

Route::get('fetch/user/accounts', [UserAccountController::class, 'fetchUsers']);

Route::get('fetch/{user}/user-account', [UserAccountController::class, 'fetchUser']);

Route::patch('deactivate/{user}/user-account', [UserAccountController::class, 'blockUser']);

Route::patch('activate/{user}/user-account', [UserAccountController::class, 'unBlockUser']);

Route::get('fetch/agency/accounts', [AdminManageUserAccountService::class, 'fetchUsers']);

Route::get('fetch/{agency}/agency-account', [AdminManageUserAccountService::class, 'fetchUser']);

Route::patch('deactivate/{agency}/agency-account', [AdminManageUserAccountService::class, 'blockUser']);

Route::patch('activate/{agency}/agency-account', [AdminManageUserAccountService::class, 'unBlockUser']);

#---------------------------- End Super Admin Routes --------------------------------------------------------------


