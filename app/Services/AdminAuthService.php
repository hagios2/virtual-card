<?php

namespace App\Services;

use App\Http\Resources\AdminResource;
use App\Http\Resources\AuthAgencyResource;
use App\Http\Resources\AuthUserResource;
use Illuminate\Http\JsonResponse as JsonResponseAlias;

class AdminAuthService extends AuthService
{
    public function login(): JsonResponseAlias
    {
        return $this->guardLogin('admin');
    }

    public function authUser(): AuthAgencyResource|AdminResource|JsonResponseAlias|AuthUserResource
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
}
