<?php

namespace App\Services;

use App\Http\Requests\AgencyRegistrationRequest;
use App\Http\Resources\AgencyResource;
use App\Http\Resources\AuthAgentResource;
use App\Http\Resources\DetailedAgencyResource;
use App\Mail\AgencyRegistrationMail;
use App\Models\Agency;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

class AdminManageAgencyAccountService extends ManageAccountService
{
    #[Pure] public function fetchAgency(Agency $agency): DetailedAgencyResource
    {
        return new DetailedAgencyResource($agency);
    }

    public function fetchAgencies(): AnonymousResourceCollection
    {
        $agencies = Agency::query()
            ->latest()->get();

        return AgencyResource::collection($agencies);
    }

    public function registerAgency(AgencyRegistrationRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $agency = Agency::create($request->safe()->only(['agency_name', 'service_type', 'branch', 'agency_location']));

            $agentData = $request->safe()->only(['name', 'email', 'phone_number']);

            $password = Str::random(8);

            $agentData['password'] = bcrypt($password);

            $agent = $agency->addAgent($agentData);

            $agent->assignRole('admin');

            Mail::to($agent)->queue(new AgencyRegistrationMail($agent, $password));

            DB::commit();

            $response = response()->json(['message' => 'agency created', 'agency' => new AgencyResource($agency)], 201);
        } catch (Exception $exception) {
            Log::info($exception->getMessage());

            DB::rollBack();

            $response = response()->json(['message' => $exception->getMessage()], 500);
        }

        return $response;
    }

    public function updateAgency(Agency $agency, AgencyRegistrationRequest $request): JsonResponse
    {
        $agency->update($request->safe()->only(['agency_name', 'service_type', 'branch', 'agency_location']));

        $agent = $agency->agent->first();

        $agent->update($request->safe()->only(['name', 'email', 'phone_number']));

        return response()->json(['message' => 'agency updated', 'agency' => new AgencyResource($agency)]);
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
