<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class TransactionResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'status' => $this->status,
            'currency' => $this->currency,
            'amount' => $this->amount,
            'email' => $this->email,
            'channel' => $this->channel,
            'ip_address' => $this->ip_address,
            'reference' => $this->reference,
            'metadata' => $this->metadata
        ];
    }
}
