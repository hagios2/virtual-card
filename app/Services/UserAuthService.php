<?php

namespace App\Services;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\AuthUserResource;
use App\Interfaces\LoginInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\JsonResponse as JsonResponseAlias;
use Illuminate\Http\Request;

class UserAuthService extends AuthService implements LoginInterface
{
    public function guardLogin(LoginRequest $request, string $guard = 'api'): JsonResponse
    {
        $credentials = request(['email', 'password']);
        $credentials['is_active'] = true;

        if (! $token = auth()->guard($guard)->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        $tokenResponse = $this->respondWithToken($token, $guard);

        $tokenResponse['user'] = $this->getAuthResource($guard);

        auth()->guard($guard)->user()->update(['last_login' => now()]);

        return response()->json($tokenResponse);
    }

    public function getAuthResource(string $guard = 'api'): AuthUserResource
    {
        return new AuthUserResource(auth()->guard($guard)->user());
    }

    public function authUser(): AuthUserResource
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

        $client = User::where('email', $request->email)->first();

        return $this->sendResetMail($client, 'user');
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        return $this->reset($request, 'user');
    }
}
