<?php

namespace App\Services;

use App\Http\Requests\VirtualCardRequest;
use GuzzleHttp\Client;


class VirtualCardService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://www.fxkudipay.com/developer/api/']);
    }

    public function initiatePayment(VirtualCardRequest $request)
    {
        $data = $request->validated();
        $data['merchantid'] = 4;
        $data['publickey'] = '12324617a7a999a8d912324617a7a999a8d9';

        $headers = [
            'Content-Type' => 'application/json'
        ];

        $response = $this->client->request('POST', 'card-generation', [
            'json' => $data,
            'headers' => $headers
        ]);

        return response()->json(['response' =>  json_decode($response->getBody()->getContents())]);
    }
}
