<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgentRequest extends FormRequest
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
            'email' => ['bail', 'required', 'string', Rule::unique('agents')->ignore($this->route()->parameter('agent'))],
            'phone_number' => ['bail', 'required', 'digits:10', Rule::unique('agents')->ignore($this->route()->parameter('agent'))],
            'role' => 'bail|required|string'
        ];
    }
}