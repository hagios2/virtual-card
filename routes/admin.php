<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AgencyAccountController;
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

Route::get('update/{admin}/admin', [AdminController::class, 'updateAdmin']);

Route::patch('deactivate/{admin}/admin-account', [AdminController::class, 'blockAdmin']);

Route::patch('activate/{admin}/admin-account', [AdminController::class, 'unBlockAdmin']);

Route::get('fetch/user/accounts', [UserAccountController::class, 'fetchUsers']);

Route::get('fetch/{user}/user-account', [UserAccountController::class, 'fetchUser']);

Route::patch('deactivate/{user}/user-account', [UserAccountController::class, 'blockUser']);

Route::patch('activate/{user}/user-account', [UserAccountController::class, 'unBlockUser']);

Route::get('fetch/agency/accounts', [AgencyAccountController::class, 'fetchAgencies']);

Route::get('fetch/{agency}/agency-account', [AgencyAccountController::class, 'fetchAgency']);

Route::patch('deactivate/{agency}/agency-account', [AgencyAccountController::class, 'blockAgency']);

Route::patch('activate/{agency}/agency-account', [AgencyAccountController::class, 'unBlockAgency']);

#---------------------------- End Super Admin Routes --------------------------------------------------------------


