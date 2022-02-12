<?php

namespace App\Services;

use App\Http\Requests\AgencyRegistrationRequest;
use App\Http\Resources\AuthAgencyResource;
use App\Mail\AgencyRegistrationMail;
use App\Models\Agency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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

    public function registerAgency(AgencyRegistrationRequest $request): JsonResponse
    {
        $agencyData = $request->validated();

        $password = Str::random(8);

        $agencyData['password'] = bcrypt($password);

        $agency = Agency::create($agencyData);

        Mail::to($agency)->queue(new AgencyRegistrationMail($agency, $password));

        return response()->json(['message' => 'admin created', 'agency' => new AuthAgencyResource($agency)], 201);
    }

    public function updateAgency(Agency $agency, AgencyRegistrationRequest $request): JsonResponse
    {
        $agency->update($request->validated());

        return response()->json(['message' => 'agency updated', 'agency' => new AuthAgencyResource($agency)]);
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
