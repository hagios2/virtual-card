<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgentRequest;
use App\Models\Agent;
use App\Services\AgencyAdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class AgencyAccountController extends Controller
{
    public function __construct(protected AgencyAdminService $agencyAdminService)
    {
        $this->middleware(['auth:agent', 'role:admin']);
    }

    public function addAgent(AgentRequest $request): JsonResponse
    {
        return $this->agencyAdminService->addAgent($request);
    }

    public function fetchAgents(): AnonymousResourceCollection
    {
        return $this->agencyAdminService->fetchAgents();
    }

    public function updateAgentAccount(Agent $agent, AgentRequest $request): JsonResponse
    {
        return $this->agencyAdminService->updateAgentAccount($agent, $request);
    }
}
