<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserServiceRequest;
use App\Http\Requests\UserSubscriptionRequest;
use App\Services\UserSubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SubscriptionController extends Controller
{
    public function __construct(protected UserSubscriptionService $subscriptionService)
    {
        $this->middleware('auth:api');
    }

    public function fetchAgencies(): AnonymousResourceCollection
    {
        return $this->subscriptionService->fetchAgencies();
    }

    public function subscribeForService(UserSubscriptionRequest $request)
    {
        return $this->subscriptionService->subscribeForService($request);
    }

    public function serviceRequest(UserServiceRequest $request): JsonResponse
    {
        return $this->subscriptionService->serviceRequest($request);
    }
}
