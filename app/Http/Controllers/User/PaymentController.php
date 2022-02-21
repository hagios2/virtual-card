<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService)
    {
        $this->middleware('auth:api')->only('viewTransactions');
    }

    public function paymentCallback(Request $request): JsonResponse
    {
        return $this->paymentService->callback($request);
    }

    public function viewTransactions(): AnonymousResourceCollection
    {
        return $this->paymentService->userViewTransactions();
    }
}
