<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use App\Services\UserAccountService;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\Pure;

class UserAccountController extends Controller
{
    public function __construct(protected UserAccountService $userAccountService)
    {
        $this->middleware('auth:api')->only('updateAccount');
    }

    public function registerUser(UserRegistrationRequest $request): JsonResponse
    {
        return $this->userAccountService->registerUser($request);
    }

    public function updateAccount(UserRegistrationRequest $request): JsonResponse
    {
        return $this->userAccountService->updateUser($request);
    }
}
