<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse as JsonResponseAlias;

interface AuthServiceInterface
{
    public function guardLogin(string $guard = 'api'): JsonResponseAlias;

    public function guardLogout(string $guard = 'api'): JsonResponseAlias;

    public function guardRefresh(string $guard = 'api'): JsonResponseAlias;

    public function respondWithToken($token, string $guard): JsonResponseAlias;
}
