<?php

namespace App\Http\Requests\cp\shop;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
class saveShopRequest extends FormRequest
{

    
    protected $fetchedLanguages;


    public function __construct() {
        parent::__construct();
        $langs =\App\Models\Language::where('status',true)->where('isDeleted',false)->get();
        $this->fetchedLanguages = $langs;   
    }


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
        //
        // 'shop_name'=>'required',
        // 'shop_address'=>'required',
        
        
        
        $rules =[
            'shop_logo'=>'required|exists:uploads,id',
            'zone_id'=>'required|exists:zones,id',
            'longitude'=>'required',
            'latitude'=>'required',
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
                function ($attribute, $value, $fail) {
                    $emailExistsInApprovalRequests = \App\Models\ApprovalRequest::where('status','pending')->whereRaw("JSON_EXTRACT(changes, '$.shop_admin_email') = ?", [$value])->exists();
                    if ($emailExistsInApprovalRequests) {
                        $fail('The email is already in pending approval requests.');
                    }
                },
            ],
            'shop_admin_phone'=>'required|unique:shop_admins,phone'
        ];


        foreach ($this->fetchedLanguages as $key=>$lang) {
            $rules["shop_name_".$lang->key] = 'required';
        }

        return $rules;
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
