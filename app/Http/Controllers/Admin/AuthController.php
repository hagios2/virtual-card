<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminAuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(protected AdminAuthService $adminAuthService)
    {
        $this->middleware('auth:admin', ['except' => ['login']]);
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
}
