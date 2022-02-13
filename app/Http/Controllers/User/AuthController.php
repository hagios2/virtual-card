<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
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

    public function login(): JsonResponse
    {
        return $this->userAuthService->login();
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

    public function reset(Request $request): JsonResponse
    {
        return $this->userAuthService->resetPassword($request);
    }
}
