<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\AuthUserResource;
use App\Models\User;
use App\Services\AdminManageUserAccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\Pure;

class UserAccountController extends Controller
{
    public function __construct(public AdminManageUserAccountService $userAccountService)
    {
        $this->middleware(['auth:admin', 'role:super admin']);
    }

    public function registerUser(UserRegistrationRequest $request): JsonResponse
    {
        return $this->userAccountService->registerUser($request);
    }

    #[Pure] public function fetchUser(User $user): AuthUserResource
    {
        return $this->userAccountService->fetchUser($user);
    }

    public function fetchUsers(): AnonymousResourceCollection
    {
        return $this->userAccountService->fetchUsers();
    }

    public function updateUser(User $user, UserRegistrationRequest $request): JsonResponse
    {
        return $this->userAccountService->updateUser($user, $request);
    }

    public function blockUser(User $user, Request $request): JsonResponse
    {
        return $this->userAccountService->blockUser($user, $request);
    }

    public function unBlockUser(User $user, Request $request): JsonResponse
    {
        return $this->userAccountService->unBlockUser($user, $request);
    }
}
