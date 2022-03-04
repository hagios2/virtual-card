<?php

namespace App\Services;

use App\Http\Requests\UserServiceRequest;
use App\Http\Requests\UserSubscriptionRequest;
use App\Http\Resources\ServicesResource;
use App\Models\Agency;
use App\Models\ServiceCharge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class UserSubscriptionService
{
    public function __construct(protected PaymentService $paymentService)
    {
    }

    public function fetchAgencies(): AnonymousResourceCollection
    {
        $agencies = Agency::query()
            ->where('is_active', true)
            ->latest()->get();

        return ServicesResource::collection($agencies);
    }

    public function subscribeForService(UserSubscriptionRequest $request)
    {
        $subscription = auth()->user()->addSubscription($request->validated());

        return response()->json(['amount' => ServiceCharge::activeCharge($request->safe()->type)->amount]);

        $paymentData = [
            'amount' => ServiceCharge::activeCharge($request->safe()->type)->amount,
            'email' => auth()->user()->email,
            'metadata' => json_encode(['subscription_id' => $subscription->id])
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
