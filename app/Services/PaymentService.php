<?php

namespace App\Services;

use App\Http\Resources\TransactionResources;
use App\Models\PaymentTransaction;
use App\Models\Subscription;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class PaymentService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://api.paystack.co/transaction/']);
    }

    public function initiatePayment($paymentData)
    {
        $headers = [
            'Authorization' => 'Bearer '.env('PAYSTACK_SEC_KEY'),
            'Content-Type' => 'application/json'
        ];

        $paymentData['currency'] = 'GHS';
        $paymentData['callback_url'] = 'https://respondergh.com/payment/verification';
        $paymentData['reference'] = 'EService-'. Str::random(10);
        $paymentData['channels'] = ['card', 'mobile_money'];

        $response = $this->client->request('POST', 'initialize', [
            'json' => $paymentData,
            'headers' => $headers
        ]);

        $paymentData['user_id'] = auth()->id();

        PaymentTransaction::create($paymentData);

        return json_decode($response->getBody()->getContents());
    }

    public function callback(Request $request): JsonResponse
    {
        $headers = ['Authorization' => 'Bearer '.env('PAYSTACK_SEC_KEY')];

        $requestReference = $request->reference;

        $responseData = $this->client->request('POST', "verify/${$requestReference}", [
            'headers' => $headers
        ]);

        $responseBody = json_decode($responseData->getBody()->getContents());

        $paymentTransaction = PaymentTransaction::query()
            ->where('reference', $requestReference)
            ->first();

            $paymentTransaction?->update([
                'channel' => $responseBody->data['channel'],
                'status' => $responseBody->data['status'],
                'ip_address' => $responseBody->data['ip_address'],
            ]);

        if ($responseBody->data['status'] === 'success') {

            $subscriptionId = json_decode($paymentTransaction?->metadata, true)['subscription_id'];

            $subscription = Subscription::find($subscriptionId);

            $subscription?->update([
                'active' => Subscription::PAID_STATUS,
                'paid_at' => now()
            ]);
        }

        return response()->json(['message' => 'received', 'payment status' => $responseBody->data['status']]);
    }

    public function userViewTransactions(): AnonymousResourceCollection
    {
        $transactions = $this->fetchTransactions()
            ->userTransactions()->get();

        return TransactionResources::collection($transactions);
    }

    public function adminViewTransactions(): AnonymousResourceCollection
    {
        return TransactionResources::collection($this->fetchTransactions()->get());
    }

    public function fetchTransactions(): Builder
    {
        return PaymentTransaction::query()
            ->latest();
    }
}
