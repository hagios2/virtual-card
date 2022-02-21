<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class UserServiceRequest extends FormRequest
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
    #[ArrayShape(['agency_id' => "string", 'reason' => "string"])] public function rules(): array
    {
        return [
            'agency_id' => 'bail|required|integer|exists:App\Model\Agency,id',
            'reason' => 'bail|required|string'
        ];
    }
}
