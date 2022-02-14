<?php

namespace App\Http\Resources;

use App\Models\Agent;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthAgencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        $agent = Agent::find($this->id);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'agency' => new AgencyResource($this->agency),
            'is_active' => $agent->is_active,
            'must_change_password' => $agent->must_change_password,
            'last_login' => $this->last_login ? Carbon::parse($this->last_login)->format('D, d F Y, g:i A') : null,
            'role' => $agent->getRoleNames()
        ];
    }
}
