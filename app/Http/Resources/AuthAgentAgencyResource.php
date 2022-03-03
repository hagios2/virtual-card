<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthAgentAgencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'agency_name' => $this->agency_name,
            'service_type' => $this->service_type,
            'is_active' => $this->is_active,
            'agency_location' => $this->agency_location,
            'branch' => $this->branch
        ];
    }
}
