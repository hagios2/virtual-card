<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\AuthUserResource;
use App\Services\UserAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected UserAuthService $userAuthService)
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->userAuthService->guardLogin($request);
    }

    public function authUser(): AuthUserResource
    {
        return $this->userAuthService->authUser();
    }

    public function logout(): JsonResponse
    {
        return $this->userAuthService->logout();
    }

    public function refresh(): JsonResponse
    {
        return $this->userAuthService->refresh();
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        return $this->userAuthService->changePassword($request);
    }

    public function sendResetMail(Request $request): JsonResponse
    {
        return $this->userAuthService->sendResetRequest($request);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        return $this->userAuthService->resetPassword($request);
    }
}
