<?php

namespace App\Services;

use App\Http\Requests\UserServiceRequest;
use App\Http\Requests\UserSubscriptionRequest;
use App\Models\Agency;
use App\Models\ServiceCharge;
use Illuminate\Http\JsonResponse;


class UserSubscriptionService
{
    public function __construct(protected PaymentService $paymentService)
    {
    }

    public function fetchAgencies()
    {
        $agencies = Agency::query()
            ->latest()->get();

        return
    }

    public function subscribeForService(UserSubscriptionRequest $request)
    {
        $subscription = auth()->user()->addSubscription($request->validated());

        $paymentData = [
            'amount' => ServiceCharge::activeCharge($request->safe()->type),
            'email' => auth()->user()->email,
            'metadata' => ['subscription_id' => $subscription->id]
        ];

       return $this->paymentService->initiatePayment($paymentData);
    }

    public function serviceRequest(UserServiceRequest $request): JsonResponse
    {
        $user = auth()->user();

        if ($user->subscription->where([['status', 'active'], ['type', $request->type]])->count() > 0)
        {
            $user->requestForService($request->validated());

            return response()->json(['message' => 'request has been submitted successfully']);
        }

        return response()->json(['message' => 'Access Denied! Service Subscription Required'], 403);
    }
}
