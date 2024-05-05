<?php

namespace App\Http\Requests\api\user;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;


class updateUserProfile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('user')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'=>'required',
            'last_name'=>'required',
            'birth_date'=>'required',
            'gender'=>'required|in:male,female'

        ];
    }
}
