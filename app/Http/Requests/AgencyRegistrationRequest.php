<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgencyRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|required|string',
            'email' => ['bail', 'required', 'string', Rule::unique('agents')->ignore($this->route()->parameter('agency')?->agent?->first())],
            'phone_number' => ['bail', 'required', 'digits:10', Rule::unique('agents')->ignore($this->route()->parameter('agency')?->agent?->first())],
            'agency_name' => 'bail|required|string',
            'agency_location' => 'bail|required|string',
            'branch' => 'bail|required|string',
            'service_type' => 'bail|required|string',
        ];
    }
}
