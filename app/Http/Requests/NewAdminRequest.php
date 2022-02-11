<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'email' => ['bail', 'required', 'string', Rule::unique('admins')->ignore($this->route()->parameter('admin')->id)],
            'phone_number' => ['bail', 'required', 'digits:10', Rule::unique('admins')->ignore($this->route()->parameter('admin')->id)],
            'role' => 'bail|required|string'
        ];
    }
}
