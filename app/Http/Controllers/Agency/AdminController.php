<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgentRequest;
use App\Http\Requests\UpdateAgencyRequest;
use App\Http\Resources\AgentResource;
use App\Models\Agent;
use App\Services\AgencyAdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\Pure;

class AdminController extends Controller
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

    #[Pure] public function fetchAnAgent(Agent $agent): AgentResource
    {
        return $this->agencyAdminService->fetchAnAgent($agent);
    }

    public function updateAgentAccount(Agent $agent, AgentRequest $request): JsonResponse
    {
        return $this->agencyAdminService->updateAgentAccount($agent, $request);
    }

    public function blockAgent(Agent $Agent): JsonResponse
    {
        return $this->agencyAdminService->blockAgent($Agent);
    }

    public function unBlockAgent(Agent $Agent): JsonResponse
    {
        return $this->agencyAdminService->unBlockAgent($Agent);
    }

    public function updateAgency(UpdateAgencyRequest $request): JsonResponse
    {
        return $this->agencyAdminService->updateAgency($request);
    }
}
