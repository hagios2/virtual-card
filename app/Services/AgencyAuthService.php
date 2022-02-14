<?php

namespace App\Services;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\AdminResource;
use App\Http\Resources\AuthAgencyResource;
use App\Http\Resources\AuthUserResource;
use App\Models\Agency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\JsonResponse as JsonResponseAlias;
use Illuminate\Http\Request;

class AgencyAuthService extends AuthService
{
    public function login(): JsonResponseAlias
    {
        return $this->guardLogin('agent');
    }

    public function authUser(): AuthAgencyResource|AdminResource|JsonResponseAlias|AuthUserResource
    {
        return $this->getAuthResource('agent');
    }

    public function logout(): JsonResponseAlias
    {
        return $this->guardLogout('agent');
    }

    public function refresh(): JsonResponseAlias
    {
        return $this->guardRefresh('agent');
    }

    public function changePassword(ChangePasswordRequest $request,): JsonResponse
    {
        return $this->changeUserPassword($request, 'agent');
    }

    public function sendResetRequest(Request $request): JsonResponse
    {
        $request->validate(['email' => 'bail|required|email']);

        $client = Agency::where('email', $request->email)->first();

        return $this->sendResetMail($client, 'agent');
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        return $this->reset($request, 'agent');
    }
}
