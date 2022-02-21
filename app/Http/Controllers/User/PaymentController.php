<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService)
    {
        $this->middleware('auth:api')->only('initiatePayment');
    }

    public function paymentCallback(Request $request)
    {
        return $this->paymentService->callback($request);
    }


}
