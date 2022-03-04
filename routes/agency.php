<?php


use App\Http\Controllers\Agency\AdminController;
use App\Http\Controllers\Agency\AgencyAccountController;
use App\Http\Controllers\Agency\AuthController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function (){

    Route::post('login', [AuthController::class, 'login']);

    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::get('user', [AuthController::class, 'authUser']);

    Route::patch('change/password', [AuthController::class, 'changePassword']);

    Route::post('send/password-reset/request', [AuthController::class, 'sendResetMail']);

    Route::post('reset/password', [AuthController::class, 'resetPassword']);
});

#-------------------------------- Admin Routes -----------------------------------------------

Route::post('add/an-agent', [AdminController::class, 'addAgent']);

Route::get('agents/fetch', [AdminController::class, 'fetchAgents']);

Route::put('update/details', [AdminController::class, 'updateAgency']);

Route::patch('deactivate/{agent}/agent-account', [AdminController::class, 'blockAgent']);

Route::patch('activate/{agent}/agent-account', [AdminController::class, 'unBlockAgent']);

#------------------------------------- Admin Routes -----------------------------------------------

Route::get('fetch/{agent}/agent', [AgencyAccountController::class, 'fetchAnAgent']);

Route::put('update/{agent}/agent/account', [AgencyAccountController::class, 'updateAgentAccount']);






