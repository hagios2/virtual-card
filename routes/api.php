<?php


use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\User\AuthController;
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

    Route::get('user', [AuthController::class, 'user']);

    Route::post('change/password', [PasswordResetController::class, 'changeUserPassword']);

    Route::post('send/password-reset/request', [PasswordResetController::class, 'sendResetMail']);

    Route::post('reset/password', [PasswordResetController::class, 'reset']);
});

Route::post('user/register', [UserAccountController::class, 'registerUser']);

Route::put('user', [UserAccountController::class, 'updateAccount']);
