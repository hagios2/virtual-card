<?php

namespace App\Services;

use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\AuthUserResource;
use App\Mail\UserRegistrationMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class UserAccountService
{
    public function registerUser(UserRegistrationRequest $request): JsonResponse
    {
        $userData = $request->safe()->except('password');

        $userData['password'] = bcrypt($request->safe()->password);

        $userData['is_active'] = false;

        $user = User::create($userData);

        Mail::to($user)->queue(new UserRegistrationMail($user));

        return response()->json(['message' => 'user created', 'user' => new AuthUserResource($user)], 201);
    }

    public function updateUser(User $user, UserRegistrationRequest $request): JsonResponse
    {
        $user->update($request->safe()->except('password'));

        return response()->json(['message' => 'account updated']);
    }
}
