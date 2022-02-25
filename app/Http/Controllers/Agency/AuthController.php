<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\AuthAgentResource;
use App\Services\AgencyAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AgencyAuthService $agencyAuthService)
    {
        $this->middleware('auth:agency', ['except' => ['login', 'sendResetMail', 'resetPassword']]);
    }

    public function login(): JsonResponse
    {
        return $this->agencyAuthService->login();
    }

    public function authUser(): AuthAgentResource
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

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        return $this->agencyAuthService->changePassword($request);
    }

    public function sendResetMail(Request $request): JsonResponse
    {
        return $this->agencyAuthService->sendResetRequest($request);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        return $this->agencyAuthService->resetPassword($request);
    }
}
