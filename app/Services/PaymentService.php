<?php

namespace App\Services;

use App\Models\PaymentCharge;
use App\Models\PaymentTransaction;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;

class PaymentService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://api.paystack.co/transaction/']);
    }

    public function initiatePayment($paymentData): string
    {
        $headers = [
            'Authorization' => 'Bearer token',
            'Content-Type' => 'application/json'
        ];

        $paymentData['currency'] = 'GHS';
        $paymentData['callback_url'] = '';
        $paymentData['reference'] = 'ESs-'. Str::random(10);
        $paymentData['channels'] = ['card', 'mobile money'];

        $response = $this->client->request('POST', 'initialize', [
            'json' => $paymentData,
            'headers' => $headers
        ]);

        return $response->getBody()->getContents();
    }

    public function callback(Request $request)
    {
        $headers = ['Authorization' => 'Bearer token'];

        $responseData = $this->client->request('POST', "verify/${$request->data['reference']}", [
            'headers' => $headers
        ]);

        $responseBody = json_decode($responseData->getBody()->getContents());

//        if ($responseBody->data['status'] === 'success') {
            PaymentTransaction::query()
                ->where('reference', $request->data['reference'])
                ->update([
                    'channel' => $responseBody->data['channel'],
                    'status' => $responseBody->data['status'],
                    'ip_address' => $responseBody->data['ip_address'],
                ]);
//        }
    }

}
