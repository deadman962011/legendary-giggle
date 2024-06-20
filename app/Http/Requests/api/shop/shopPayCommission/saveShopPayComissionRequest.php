<?php

namespace App\Http\Requests\api\shop\shopPayCommission;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class saveShopPayComissionRequest extends FormRequest
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
            'amount'=>'required|numeric',
            'offer_id'=>'required',
            'full_name'=>'required',
            'phone'=>'required',
            'deposit_at'=>'required|date',
            'deposit_bank_account_id'=>'required|exists:deposit_bank_accounts,id',
            'attachments'=>'required'
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
