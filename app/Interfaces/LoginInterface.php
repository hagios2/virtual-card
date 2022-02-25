<?php

namespace App\Interfaces;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\AuthAdminResource;
use App\Http\Resources\AuthAgentResource;
use App\Http\Resources\AuthUserResource;
use Illuminate\Http\JsonResponse;

interface LoginInterface
{
    public function guardLogin(LoginRequest $request, string $guard = 'api'): JsonResponse;

    public function getAuthResource(string $guard = 'api'): AuthUserResource|AuthAgentResource|AuthAdminResource;
}
