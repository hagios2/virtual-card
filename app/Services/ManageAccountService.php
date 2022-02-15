<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class ManageAccountService
{
    public function blockAccount($account): JsonResponse
    {
        if ($account->is_active) {
            $account->update(['is_active' => false]);

            $this->storeComment($account, request()->reason_for_blocking, 'reason_for_blocking');

            return response()->json(['message' => 'deactivated']);
        }

        return response()->json(['message' => 'account already deactivated']);
    }

    public function unBlockAccount($account): JsonResponse
    {
        if (!$account->is_active) {
            $account->update(['is_active' => true]);

            $this->storeComment($account, request()->reason_for_unblocking, 'reason_for_unblocking');

            return response()->json(['message' => 'activated']);
        }

        return response()->json(['message' => 'account already activated']);
    }

    public function storeComment($account, $comment, $commentField) {
        if ($account instanceof User) {
            $previousActiveComment = $account->accountsComment
                    ->where([['status', 'active'], [$commentField, null]])
                    ->latest()->first();
            if ($previousActiveComment) {
                $previousActiveComment->update([$commentField => $comment, 'status' => 'closed']);
            } else {
                $account->addAccountComment(['reason_for_blocking' => $comment]);
            }
        }
    }
}
