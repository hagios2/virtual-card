<?php

namespace App\Services;

use App\Http\Requests\AgencyRegistrationRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\AuthAgencyResource;
use App\Http\Resources\AuthUserResource;
use App\Mail\AgencyRegistrationMail;
use App\Models\Agency;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

class AdminManageUserAccountService extends ManageAccountService
{
    #[Pure] public function fetchUser(User $user): AuthUserResource
    {
        return new AuthUserResource($user);
    }

    public function fetchUsers(): AnonymousResourceCollection
    {
        $users = User::query()
            ->latest()->get();

        return AuthUserResource::collection($users);
    }

    public function registerAgency(AgencyRegistrationRequest $request): JsonResponse
    {
        $agencyData = $request->validated();

        $password = Str::random(8);

        $agencyData['password'] = bcrypt($password);

        $agency = Agency::create($agencyData);

        Mail::to($agency)->queue(new AgencyRegistrationMail($agency, $password));

        return response()->json(['message' => 'agency created', 'agency' => new AuthAgencyResource($agency)], 201);
    }

    public function updateUser(User $user, UserRegistrationRequest $request): JsonResponse
    {
        $user->update($request->validated());

        return response()->json(['message' => 'user updated']);
    }

    public function blockUser(User $user): JsonResponse
    {
        return $this->blockAccount($user);
    }

    public function unBlockUser(User $user): JsonResponse
    {
        return $this->unBlockAccount($user);
    }
}
