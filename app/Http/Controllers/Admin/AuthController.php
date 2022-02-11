<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Services\AdminAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AdminAuthService $adminAuthService)
    {
        $this->middleware('auth:admin', ['except' => ['login', 'sendResetMail', 'reset']]);
    }

    public function login(): JsonResponse
    {
        return $this->adminAuthService->login();
    }

    public function authUser(): JsonResponse
    {
        return $this->adminAuthService->authUser();
    }

    public function logout(): JsonResponse
    {
        return $this->adminAuthService->logout();
    }

    public function refresh(): JsonResponse
    {
        return $this->adminAuthService->refresh();
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        return $this->adminAuthService->changePassword($request);
    }

    public function sendResetMail(Request $request): JsonResponse
    {
        return $this->adminAuthService->sendResetRequest($request);
    }

    public function reset(Request $request): JsonResponse
    {
        return $this->adminAuthService->resetPassword($request);
    }
}
