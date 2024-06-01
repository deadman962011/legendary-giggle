<?php

namespace App\Http\Requests\api\shop;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class saveShopRequest extends FormRequest
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
            'shop_name'=>'required',
            // 'shop_logo'=>'required|exists:uploads,id',
            // 'shop_address'=>'required',
            'longitude'=>'required',
            'latitude'=>'required',
            'zone_id'=>'required|exists:zones,id',
            'district_id'=>'required|exists:districts,id',
            'categories_ids'=>'required',
            'tax_register'=>[
                'required',
                'unique:shops,tax_register',
                function ($attribute, $value, $fail) {
                    $emailExistsInApprovalRequests = \App\Models\ApprovalRequest::where('status','pending')->whereRaw("JSON_EXTRACT(changes, '$.tax_register') = ?", [$value])->exists();
                    if ($emailExistsInApprovalRequests) {
                        $fail('tex register is already in pending approval requests.');
                    }
                }
            ],
            'shop_admin_name'=>'required',
            'shop_admin_email'=>[
                'required',
                'unique:shop_admins,email',
            ],
            'shop_admin_phone'=>[
                'required',
                'unique:shop_admins,phone',
                function ($attribute, $value, $fail) {
                    $phoneExistsInApprovalRequests = \App\Models\ApprovalRequest::where('status','pending')->whereRaw("JSON_EXTRACT(changes, '$.shop_admin_phone') = ?", [$value])->exists();
                    if ($phoneExistsInApprovalRequests) {
                        $fail('The phone is already in pending approval requests.');
                    }
                },
            ]
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
