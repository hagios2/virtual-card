<?php

namespace App\Services;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\AuthAgencyResource;
use App\Models\Agent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\JsonResponse as JsonResponseAlias;
use Illuminate\Http\Request;

class AgencyAuthService extends AuthService
{
    public function login(): JsonResponseAlias
    {
        return $this->guardLogin('agent');
    }

    public function authUser(): AuthAgencyResource
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

        $client = Agent::where('email', $request->email)->first();

        return $this->sendResetMail($client, 'agent');
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        return $this->reset($request, 'agent');
    }
}
