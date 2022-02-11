<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserAccountController extends Controller
{

    public function blockUser(User $user): JsonResponse
    {
        return $this->adminService->blockUser($user);
    }

    public function unBlockUser(User $user): JsonResponse
    {
        return $this->adminService->unBlockUser($user);
    }
}
