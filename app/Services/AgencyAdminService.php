<?php

namespace App\Services;

use App\Http\Requests\AgentRequest;
use App\Http\Resources\AgentResource;
use App\Http\Resources\AuthAgentResource;
use App\Mail\AgencyRegistrationMail;
use App\Models\Agent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AgencyAdminService extends ManageAccountService
{
    public function addAgent(AgentRequest $request): JsonResponse
    {
        $agentData = $request->safe()->except('role');

        $password = Str::random(8);

        $agentData['password'] = bcrypt($password);

        $agent = auth()->guard('agent')->user()->agency->addAgent($agentData);

        $agent->assignRole($request->safe()->role);

        Mail::to($agent)->queue(new AgencyRegistrationMail($agent, $password));

        return response()->json(['message' => 'agent created', 'agent' => new AuthAgentResource($agent)], 201);
    }

    public function fetchAgents(): AnonymousResourceCollection
    {
        $agents = Agent::query()
            ->where('agency_id', auth()->guard('agent')->user()->agency_id)
            ->latest()->get();

        return AgentResource::collection($agents);
    }

    public function updateAgentAccount(Agent $agent, AgentRequest $request): JsonResponse
    {
        $agent->update($request->safe()->except('role'));

        $agent->syncRoles($request->safe()->role);

        return response()->json(['message' => 'agent updated', 'agent' => new AgentResource($agent)]);
    }

    public function blockAgent(Agent $agent): JsonResponse
    {
        return $this->blockAccount($agent);
    }

    public function unBlockAgent(Agent $agent): JsonResponse
    {
        return $this->unBlockAccount($agent);
    }
}
