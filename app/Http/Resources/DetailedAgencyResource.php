<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedAgencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'agency_name' => $this->agency_name,
            'service_type' => $this->service_type,
            'agents' => AgentResource::collection($this->agent),
            'agency_location' => $this->agency_location,
            'branch' => $this->branch
        ];
    }
}
