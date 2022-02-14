<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgencyRegistrationRequest;
use App\Models\Agent;
use App\Services\AgencyAdminService;
use Illuminate\Http\JsonResponse;


class AgencyAccountController extends Controller
{
    public function __construct(protected AgencyAdminService $agencyAdminService)
    {
        $this->middleware(['auth:agent', 'role:admin']);
    }

    public function addAgent(AgencyRegistrationRequest $request): JsonResponse
    {
        return $this->userAccountService->addAgent($request);
    }

    public function updateAgentAccount(Agent $agent, AgencyRegistrationRequest $request): JsonResponse
    {
        return $this->userAccountService->updateAgent($agent, $request);
    }
}
