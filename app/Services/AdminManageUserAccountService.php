<?php

namespace App\Services;

use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\AuthUserResource;
use App\Mail\AdminUserRegistrationMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    public function registerUser(UserRegistrationRequest $request): JsonResponse
    {
        $password = Str::random(8);

        $userData = $request->except('password');

        $userData['password'] = bcrypt($password);

        $userData['must_change_password'] = true;

        $user = User::create($userData);

        Mail::to($user)->queue(new AdminUserRegistrationMail($user, $password));

        return response()->json(['message' => 'user created', 'user' => new AuthUserResource($user)], 201);
    }

    public function updateUser(User $user, UserRegistrationRequest $request): JsonResponse
    {
        $user->update($request->except('password'));

        return response()->json(['message' => 'user updated', 'user' => new AuthUserResource($user)]);
    }

    public function blockUser(User $user, Request $request): JsonResponse
    {
        $comment = $request->validate(['reason_for_comment' => 'bail|required|string']);

        return $this->blockAccount($user);
    }

    public function unBlockUser(User $user): JsonResponse
    {
        return $this->unBlockAccount($user);
    }
}
