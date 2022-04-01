<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VirtualCardRequest extends FormRequest
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
    public function rules()
    {
        return [
            'cardholder' => 'required|string',
            'customer_name' => 'required|string',
            'customer_email' => 'required|email|string',
            'customer_phone' => 'required|digits:10',
            'reference' => 'required|string',
        ];
    }
}
