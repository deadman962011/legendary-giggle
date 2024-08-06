<?php

namespace App\Http\Requests\cp\offer;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class saveOfferRequest extends FormRequest
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

        $rules=[];
        foreach ($this->fetchedLanguages as $key=>$lang) {
            $rules["name_".$lang->key] = 'required';
        }

        $rules=[
            'start_date'=>'required',
            'end_date'=>'required',
            'cashback_amount'=>'required|numeric',
            'offer_thumbnail'=>'required|numeric',
            'shop_id'=>'required|exists:shops,id'
        ];

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
