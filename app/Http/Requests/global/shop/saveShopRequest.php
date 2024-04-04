<?php

namespace App\Http\Requests\global\shop;

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
            'shop_logo'=>'required|exists:uploads,id',
            'longitude'=>'required',
            'latitude'=>'required',
            'tax_register'=>'required',
            'shop_admin_name'=>'required',
            'shop_admin_email'=>'required|unique:shop_admins,email',
            'shop_admin_phone'=>'required'
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
