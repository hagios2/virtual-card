<?php

namespace App\Services;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\AuthAdminResource;
use App\Interfaces\LoginInterface;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\JsonResponse as JsonResponseAlias;
use Illuminate\Http\Request;

class AdminAuthService extends AuthService implements LoginInterface
{
    public function guardLogin(LoginRequest $request, string $guard = 'api'): JsonResponse
    {
        $credentials = $request->validated();
        $credentials['is_active'] = true;

        if (! $token = auth()->guard($guard)->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        $tokenResponse = $this->respondWithToken($token, $guard);

        $tokenResponse['user'] = $this->getAuthResource($guard);

        return response()->json($tokenResponse);
    }

    public function authUser(): AuthAdminResource
    {
        return $this->getAuthResource('admin');
    }

    public function getAuthResource(string $guard = 'api'): AuthAdminResource
    {
        return new AuthAdminResource(auth()->guard($guard)->user());
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
