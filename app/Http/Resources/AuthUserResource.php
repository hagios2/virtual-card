<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class AuthUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone_number' =>  $this->phone_number,
            'postal_address' => $this->postal_address,
            'physical_address' => $this->physical_address,
            'property_color' => $this->property_color,
            'closest_landmark' => $this->closest_landmark,
            'property_description' => $this->property_description,
            'special_note' => $this->special_note,
            'emergency_contact1_name' => $this->emergency_contact1_name,
            'emergency_contact1_phone_number' => $this->emergency_contact1_phone_number,
            'emergency_contact2_name' => $this->emergency_contact2_name,
            'emergency_contact2_phone_number' => $this->emergency_contact2_phone_number,
            'emergency_contact3_name' => $this->emergency_contact3_name,
            'emergency_contact3_phone_number' => $this->emergency_contact3_phone_number,
            'lat' => $this->lat,
            'lng' => $this->lng,
        ];
    }
}
