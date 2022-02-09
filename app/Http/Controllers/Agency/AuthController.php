<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Services\AgencyAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AgencyAuthService $agencyAuthService)
    {
        $this->middleware('auth:agency', ['except' => ['login']]);
    }

    public function login(): JsonResponse
    {
        return $this->agencyAuthService->login();
    }

    public function authUser(): JsonResponse
    {
        return $this->agencyAuthService->authUser();
    }

    public function logout(): JsonResponse
    {
        return $this->agencyAuthService->logout();
    }

    public function refresh(): JsonResponse
    {
        return $this->agencyAuthService->refresh();
    }
}
