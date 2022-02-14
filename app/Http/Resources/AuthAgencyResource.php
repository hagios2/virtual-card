<?php

namespace App\Http\Resources;

use App\Models\Agency;
use App\Models\Agent;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthAgencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $agency = Agent::find($this->id);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'agency' => $this->agency,
            'is_active' => $agency->is_active,
            'must_change_password' => $agency->must_change_password,
            'last_login' => $this->last_login ? Carbon::parse($this->last_login)->format('D, d F Y, g:i A') : null,
        ];
    }
}
