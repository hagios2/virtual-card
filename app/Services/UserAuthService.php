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

class UserAuthService extends AuthService
{
    public function login(): JsonResponseAlias
    {
        return $this->guardLogin();
    }

    public function authUser(): AuthAgencyResource|AdminResource|JsonResponseAlias|AuthUserResource
    {
        return $this->getAuthResource();
    }

    public function logout(): JsonResponseAlias
    {
        return $this->guardLogout();
    }

    public function refresh(): JsonResponseAlias
    {
        return $this->guardRefresh();
    }

    public function changePassword(ChangePasswordRequest $request,): JsonResponse
    {
        return $this->changeUserPassword($request, 'api');
    }

    public function sendResetRequest(Request $request): JsonResponse
    {
        $request->validate(['email' => 'bail|required|email']);

        $client = Admin::where('email', $request->email)->first();

        return $this->sendResetMail($client, 'user');
    }

    public function resetPassword(Request $request): JsonResponse
    {
        return $this->reset($request, 'user');
    }
}
