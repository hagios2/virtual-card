<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthUserResource;
use App\Models\User;
use App\Services\AdminManageUserAccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\Pure;

class UserAccountController extends Controller
{
    public function __construct(public AdminManageUserAccountService $userAccountService)
    {
    }

    #[Pure] public function fetchUser(User $user): AuthUserResource
    {
        return $this->userAccountService->fetchUser($user);
    }

    public function fetchUsers(): AnonymousResourceCollection
    {
        return $this->userAccountService->fetchUsers();
    }

    public function blockUser(User $user): JsonResponse
    {
        return $this->userAccountService->blockUser($user);
    }

    public function unBlockUser(User $user): JsonResponse
    {
        return $this->userAccountService->unBlockUser($user);
    }
}
