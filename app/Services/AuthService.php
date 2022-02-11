<?php

namespace App\Services;

use App\Http\Resources\AdminResource;
use App\Http\Resources\AuthAgencyResource;
use App\Http\Resources\AuthUserResource;
use App\Interfaces\AuthServiceInterface;
use Illuminate\Http\JsonResponse as JsonResponseAlias;

class AuthService implements AuthServiceInterface
{
    public function guardLogin(string $guard = 'api'): JsonResponseAlias
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->guard($guard)->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token, $guard);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponseAlias
     */
    public function guardLogout(string $guard = 'api'): JsonResponseAlias
    {
        auth()->guard($guard)->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponseAlias
     */
    public function guardRefresh(string $guard = 'api'): JsonResponseAlias
    {
        return $this->respondWithToken(auth()->guard($guard)->refresh(), $guard);
    }


    public function respondWithToken($token, string $guard): JsonResponseAlias
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $this->getAuthResource($guard)
        ]);
    }

    public function getAuthResource(string $guard = 'api'): AuthAgencyResource|AdminResource|AuthUserResource
    {
        return match ($guard) {
            'api' => new AuthUserResource(auth()->user()),
            'admin' => new AdminResource(auth()->guard($guard)->user()),
            'agency' => new AuthAgencyResource(auth()->guard($guard)->user())
        };
    }
}
