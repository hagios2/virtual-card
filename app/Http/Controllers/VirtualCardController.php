<?php

namespace App\Http\Controllers;

use App\Http\Requests\VirtualCardRequest;
use App\Services\VirtualCardService;
use Illuminate\Http\JsonResponse;

class VirtualCardController extends Controller
{
    public function __construct(protected VirtualCardService $paymentService)
    {
    }

    public function paymentCallback(VirtualCardRequest $request): JsonResponse
    {
        return $this->paymentService->initiatePayment($request);
    }
}
