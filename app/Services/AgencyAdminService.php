<?php

namespace App\Services;

use App\Http\Requests\AgencyRegistrationRequest;
use App\Http\Resources\AgentResource;
use App\Http\Resources\AuthAgencyResource;
use App\Mail\AgencyRegistrationMail;
use App\Models\Agent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AgencyAdminService
{
    public function addAgent(AgencyRegistrationRequest $request): JsonResponse
    {
        $agentData = $request->safe()->except(['agency_name', 'service_type', 'registered_by_admin']);

        $password = Str::random(8);

        $agentData['password'] = bcrypt($password);

        $agent = auth()->guard('agent')->user()->agency->addAgent($agentData);

        $agent->assignRole($request->safe()->role);

        Mail::to($agent)->queue(new AgencyRegistrationMail($agent, $password));

        return response()->json(['message' => 'agent created', 'agent' => new AuthAgencyResource($agent)], 201);
    }

    public function fetchAgents(): AnonymousResourceCollection
    {
        $agents = Agent::query()
            ->where('agency_id', auth()->guard('agent')->user()->agency_id)
            ->latest()->get();

        return AgentResource::collection($agents);
    }

    public function updateAgentAccount(Agent $agent, AgencyRegistrationRequest $request): JsonResponse
    {
        $agent->update($request->safe()->except(['agency_name', 'service_type', 'registered_by_admin', 'role']));

        $agent->syncRoles($request->safe()->role);

        return response()->json(['message' => 'agent updated', 'agent' => new AgentResource($agent)]);
    }
}
