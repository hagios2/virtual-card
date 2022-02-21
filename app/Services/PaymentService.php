<?php

namespace App\Services;

use App\Models\PaymentTransaction;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
            'Authorization' => 'Bearer token',
            'Content-Type' => 'application/json'
        ];

        $paymentData['currency'] = 'GHS';
        $paymentData['callback_url'] = '';
        $paymentData['reference'] = 'EService-'. Str::random(10);
        $paymentData['channels'] = ['card', 'mobile money'];

        $response = $this->client->request('POST', 'initialize', [
            'json' => $paymentData,
            'headers' => $headers
        ]);

        PaymentTransaction::create($paymentData);

        return json_decode($response->getBody()->getContents());
    }

    public function callback(Request $request): JsonResponse
    {
        $headers = ['Authorization' => 'Bearer token'];

        $responseData = $this->client->request('POST', "verify/${$request->data['reference']}", [
            'headers' => $headers
        ]);

        $responseBody = json_decode($responseData->getBody()->getContents());

        PaymentTransaction::query()
            ->where('reference', $request->data['reference'])
            ->update([
                'channel' => $responseBody->data['channel'],
                'status' => $responseBody->data['status'],
                'ip_address' => $responseBody->data['ip_address'],
            ]);

        if ($responseBody->data['status'] === 'success') {

        }

        return response()->json(['message' => 'received']);
    }

}
