<?php

namespace App\Services;

use App\Http\Requests\NewAdminRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\AdminResource;
use App\Http\Resources\AuthUserResource;
use App\Mail\NewAminMail;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Mail;

class UserAccountService
{
    public function createAdmin(UserRegistrationRequest $request): JsonResponse
    {
        $userData = $request->safe()->except('password');

        $userData['password'] = bcrypt($request->safe()->password);

        $user = User::create($userData);

        Mail::to($user)->queue(new ($user));

        return response()->json(['message' => 'admin created', 'admin' => new AuthUserResource($user)], 201);
    }

    public function updateUser(UserRegistrationRequest $request): JsonResponse
    {
        auth()->user()->update($request->safe()->except('password'));

        return response()->json(['message' => 'account updated', 'admin' ], 201);
    }
}
