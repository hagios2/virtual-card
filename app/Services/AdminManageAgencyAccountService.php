<?php

namespace App\Services;

use App\Http\Resources\AuthAgencyResource;
use App\Models\Agency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\Pure;

class AdminManageAgencyAccountService extends ManageAccountService
{
    #[Pure] public function fetchAgency(Agency $agency): AuthAgencyResource
    {
        return new AuthAgencyResource($agency);
    }

    public function fetchAgencies(): AnonymousResourceCollection
    {
        $agencies = Agency::query()
            ->latest()->get();

        return AuthAgencyResource::collection($agencies);
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
