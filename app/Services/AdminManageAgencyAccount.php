<?php

namespace App\Services;

use App\Http\Resources\AuthUserResource;
use App\Models\Agency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\Pure;

class AdminManageAgencyAccount extends ManageAccountService
{
    #[Pure] public function fetchAgency(Agency $agency): AuthUserResource
    {
        return new AuthUserResource($agency);
    }

    public function fetchAgencies(): AnonymousResourceCollection
    {
        $agencies = Agency::query()
            ->latest()->get();

        return AuthUserResource::collection($agencies);
    }

    public function blockAgency(Agency $agency): JsonResponse
    {
        return $this->blockAccount($agency);
    }

    public function unBlockAgency(Agency $agency): JsonResponse
    {
        return $this->unBlockAccount($agency);
    }
}
