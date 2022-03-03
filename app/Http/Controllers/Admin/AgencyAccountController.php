<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgencyRegistrationRequest;
use App\Http\Resources\DetailedAgencyResource;
use App\Models\Agency;
use App\Models\Agent;
use App\Services\AdminManageAgencyAccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\Pure;

class AgencyAccountController extends Controller
{
    public function __construct(public AdminManageAgencyAccountService $agencyAccountService)
    {
        $this->middleware(['auth:admin', 'role:super admin|admin|data entry user']);
    }

    public function registerAgency(AgencyRegistrationRequest $request): JsonResponse
    {
        return $this->agencyAccountService->registerAgency($request);
    }

    #[Pure] public function fetchAgency(Agency $Agency): DetailedAgencyResource
    {
        return $this->agencyAccountService->fetchAgency($Agency);
    }

    public function fetchAgencies(): AnonymousResourceCollection
    {
        return $this->agencyAccountService->fetchAgencies();
    }

    public function updateAccount(Agency $agency, AgencyRegistrationRequest $request): JsonResponse
    {
        return $this->agencyAccountService->updateAgency($agency, $request);
    }

    public function blockAgency(Agency $Agency): JsonResponse
    {
        return $this->agencyAccountService->blockAgency($Agency);
    }

    public function unBlockAgency(Agency $Agency): JsonResponse
    {
        return $this->agencyAccountService->unBlockAgency($Agency);
    }

    public function blockAgent(Agent $Agent): JsonResponse
    {
        return $this->agencyAccountService->blockAgent($Agent);
    }

    public function unBlockAgent(Agent $Agent): JsonResponse
    {
        return $this->agencyAccountService->unBlockAgent($Agent);
    }
}
