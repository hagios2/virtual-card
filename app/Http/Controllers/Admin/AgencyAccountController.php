<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgencyRegistrationRequest;
use App\Http\Resources\AgencyResource;
use App\Http\Resources\AuthAgencyResource;
use App\Models\Agency;
use App\Services\AdminManageAgencyAccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\Pure;

class AgencyAccountController extends Controller
{
    public function __construct(public AdminManageAgencyAccountService $agencyAccountService)
    {
        $this->middleware(['auth:admin', 'role:super admin']);
    }

    public function registerAgency(AgencyRegistrationRequest $request): JsonResponse
    {
        return $this->agencyAccountService->registerAgency($request);
    }

    #[Pure] public function fetchAgency(Agency $Agency): AgencyResource
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
}
