<?php


use App\Http\Controllers\Agency\AgencyAccountController;
use App\Http\Controllers\Agency\AuthController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function (){

    Route::post('login', [AuthController::class, 'login']);

    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::get('user', [AuthController::class, 'authUser']);

    Route::post('change/password', [AuthController::class, 'changePassword']);

    Route::post('send/password-reset/request', [AuthController::class, 'sendResetMail']);

    Route::post('reset/password', [AuthController::class, 'resetPassword']);
});

Route::post('add/an-agent', [AgencyAccountController::class, 'addAgent']);

Route::post('update/{agent}/agent/account', [AgencyAccountController::class, 'updateAgentAccount']);

Route::get('agents/fetch', [AgencyAccountController::class, 'fetchAgents']);


