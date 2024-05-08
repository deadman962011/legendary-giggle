<?php

namespace App\Http\Requests\cp\staff;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class saveStaffRequest extends FormRequest

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
            'name'=>'required',
            'email'=>'reqiored|email|unique:admins,email',
            'role_id'=>'required|exists:roles,id'
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


    public function messages()
    {
    
        $messages = [];

        foreach ($this->fetchedLanguages as $lang) {
            $messages["name_".$lang->key.".required"] = "shop name in ".$lang->name." is required.";
        }

        return $messages;
    }





}
