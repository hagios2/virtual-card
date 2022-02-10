<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\AdminAuthService;
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

    public function authUser(): JsonResponse
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
}