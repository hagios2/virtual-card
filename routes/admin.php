<?php


use App\Http\Controllers\Admin\AdminController;
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

#---------------------------- Staff Routes --------------------------------

Route::post('add/admin', [AdminController::class, 'createAmin']);

Route::get('fetch/admins', [AdminController::class, 'fetchAnAdmin']);

Route::get('fetch/{admin}/admin', [AdminController::class, 'fetchAnAdmin']);

Route::patch('deactivate/{admin}/admin-account', [AdminController::class, 'blockAdmin']);

Route::patch('activate/{admin}/admin-account', [AdminController::class, 'unBlockAdmin']);

#---------------------------- End Staff Routes --------------------------------


