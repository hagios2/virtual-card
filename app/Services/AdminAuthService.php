<?php

namespace App\Services;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\JsonResponse as JsonResponseAlias;
use Illuminate\Http\Request;

class AdminAuthService extends AuthService
{
    public function login(): JsonResponseAlias
    {
        return $this->guardLogin('admin');
    }

    public function authUser(): AdminResource
    {
        return $this->getAuthResource('admin');
    }

    public function logout(): JsonResponseAlias
    {
        return $this->guardLogout('admin');
    }

    public function refresh(): JsonResponseAlias
    {
        return $this->guardRefresh('admin');
    }

    public function changePassword(ChangePasswordRequest $request,): JsonResponse
    {
        return $this->changeUserPassword($request, 'admin');
    }

    public function sendResetRequest(Request $request): JsonResponse
    {
        $request->validate(['email' => 'bail|required|email']);

        $client = Admin::where('email', $request->email)->first();

        return $this->sendResetMail($client, 'admin');
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        return $this->reset($request, 'admin');
    }
}
