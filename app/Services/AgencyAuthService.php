<?php

namespace App\Services;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Resources\AdminResource;
use App\Http\Resources\AuthAgencyResource;
use App\Http\Resources\AuthUserResource;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\JsonResponse as JsonResponseAlias;
use Illuminate\Http\Request;

class AgencyAuthService extends AuthService
{
    public function login(): JsonResponseAlias
    {
        return $this->guardLogin('agency');
    }

    public function authUser(): AuthAgencyResource|AdminResource|JsonResponseAlias|AuthUserResource
    {
        return $this->getAuthResource('agency');
    }

    public function logout(): JsonResponseAlias
    {
        return $this->guardLogout('agency');
    }

    public function refresh(): JsonResponseAlias
    {
        return $this->guardRefresh('agency');
    }

    public function changePassword(ChangePasswordRequest $request,): JsonResponse
    {
        return $this->changeUserPassword($request, 'agency');
    }

    public function sendResetRequest(Request $request): JsonResponse
    {
        $request->validate(['email' => 'bail|required|email']);

        $client = Admin::where('email', $request->email)->first();

        return $this->sendResetMail($client, 'agency');
    }

    public function resetPassword(Request $request): JsonResponse
    {
        return $this->reset($request, 'agency');
    }
}
