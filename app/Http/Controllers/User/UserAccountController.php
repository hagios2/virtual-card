<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerificationRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use App\Services\UserAccountService;
use Illuminate\Http\JsonResponse;

class UserAccountController extends Controller
{
    public function __construct(protected UserAccountService $userAccountService)
    {
        $this->middleware('auth:api')->only(['updateAccount', 'resendVerificationLink']);
    }

    public function registerUser(UserRegistrationRequest $request): JsonResponse
    {
        return $this->userAccountService->registerUser($request);
    }

    public function updateAccount(User $user, UserRegistrationRequest $request): JsonResponse
    {
        return $this->userAccountService->updateUser($user, $request);
    }

    public function verifyEmail(EmailVerificationRequest $request): JsonResponse
    {
        return $this->userAccountService->verifyEmail($request);
    }

    public function resendVerificationLink(): JsonResponse
    {
        return $this->userAccountService->resendVerificationLink();
    }
}
