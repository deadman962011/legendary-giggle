<?php

namespace App\Http\Requests\api\shop;
 
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AuthenticateShopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            // 
            'email'=>[
                'required',
                // 'unique:shop_admins,email',
                function ($attribute, $value, $fail) {
                    $emailExistsInApprovalRequests = \App\Models\ApprovalRequest::where('status','pending')->whereRaw("JSON_EXTRACT(changes, '$.shop_admin_email') = ?", [$value])->exists();
                    if ($emailExistsInApprovalRequests) {
                        $fail('The email is already in pending approval requests.');
                    }
                },
            ],
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => __('custom.validation_error'),
            'errors'      => $validator->errors()
        ],422));
    }
}
