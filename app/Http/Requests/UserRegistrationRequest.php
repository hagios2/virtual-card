<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRegistrationRequest extends FormRequest
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
            'registered_by_admin' => 'bail|boolean|required',
            'name' => 'bail|required|string',
            'password' => request()->method() === 'POST' ? 'bail|required_if:registered_by_admin,false|string' : 'bail|nullable|string',
            'postal_address' => 'bail|required|string',
            'physical_address' => 'bail|required|string',
            'property_color' => 'bail|required|string',
            'closest_landmark' => 'bail|required|string',
            'property_description' => 'bail|required|string',
            'special_note' => 'bail|required|string',
            'lat' => 'bail|required|numeric',
            'lng' => 'bail|required|numeric',
            'emergency_contact1_name' => 'bail|required|string',
            'emergency_contact2_name' => 'bail|nullable|string',
            'emergency_contact3_name' => 'bail|nullable|string',
            'email' => ['bail', 'required', 'string', Rule::unique('users')->ignore($this->user('api')->id)],
            'phone_number' => ['bail', 'required', 'digits:10', Rule::unique('users')->ignore($this->user('api')->id)],
            'emergency_contact1_phone_number' => ['bail', 'required', 'digits:10', Rule::unique('users')->ignore($this->user('api')->id)],
            'emergency_contact2_phone_number' => ['bail', 'nullable', 'required_with:emergency_contact2_name', 'digits:10', Rule::unique('users')->ignore($this->user('api')->id)],
            'emergency_contact3_phone_number' => ['bail', 'nullable', 'required_with:emergency_contact3_name','digits:10', Rule::unique('users')->ignore($this->user('api')->id)],
        ];
    }
}
