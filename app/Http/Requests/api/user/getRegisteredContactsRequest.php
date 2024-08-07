<?php

namespace App\Http\Requests\api\user;

use Illuminate\Foundation\Http\FormRequest;

class getRegisteredContactsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'phone_numbers' => 'required|array',
            'phone_numbers.*' => 'required|string|max:255'


        ];
    }
}
