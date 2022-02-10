<?php


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
