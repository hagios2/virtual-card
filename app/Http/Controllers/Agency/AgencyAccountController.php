<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgentRequest;
use App\Http\Resources\AgentResource;
use App\Models\Agent;
use App\Services\AgencyAdminService;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\Pure;


class AgencyAccountController extends Controller
{
    public function __construct(protected AgencyAdminService $agencyAdminService)
    {
        $this->middleware(['auth:agent', 'role:admin|user']);
    }

    #[Pure] public function fetchAnAgent(Agent $agent): AgentResource
    {
        return $this->agencyAdminService->fetchAnAgent($agent);
    }

    public function updateAgentAccount(Agent $agent, AgentRequest $request): JsonResponse
    {
        return $this->agencyAdminService->updateAgentAccount($agent, $request);
    }
}
