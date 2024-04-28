<?php

namespace App\Http\Requests\cp\zone;

use Illuminate\Foundation\Http\FormRequest;


use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class saveZoneRequest extends FormRequest
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
        
        foreach ($this->fetchedLanguages as $key=>$lang) {
            $rules["name_".$lang->key] = 'required';
        }
        $rules['coordinates']=['required'];
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
            $messages["name_".$lang->key.".required"] = "zone name in ".$lang->name." is required.";
        }

        return $messages;
    }


}
