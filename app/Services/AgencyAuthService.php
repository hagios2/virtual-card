<?php

namespace App\Services;

use App\Http\Resources\AuthAdminResource;
use App\Http\Resources\AuthAgencyResource;
use App\Http\Resources\AuthUserResource;
use Illuminate\Http\JsonResponse as JsonResponseAlias;

class AgencyAuthService extends AuthService
{
    public function login(): JsonResponseAlias
    {
        return $this->guardLogin('agency');
    }

    public function authUser(): AuthAgencyResource|AuthAdminResource|JsonResponseAlias|AuthUserResource
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
}
