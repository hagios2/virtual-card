<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService)
    {
        $this->middleware('auth:admin');
    }

    public function viewTransactions(): AnonymousResourceCollection
    {
        return $this->paymentService->adminViewTransactions();
    }
}
