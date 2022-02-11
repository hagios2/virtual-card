<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ManageAccountService
{
    public function blockAccount($account): JsonResponse
    {
        if ($account->is_active) {
            $account->update(['is_active' => false]);

            return response()->json(['message' => 'deactivated']);
        }

        return response()->json(['message' => 'account already deactivated']);
    }

    public function unBlockAccount($account): JsonResponse
    {
        if (!$account->is_active) {
            $account->update(['is_active' => true]);

            return response()->json(['message' => 'activated']);
        }

        return response()->json(['message' => 'account already activated']);
    }
}
