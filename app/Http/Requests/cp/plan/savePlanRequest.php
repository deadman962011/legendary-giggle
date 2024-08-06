<?php

namespace App\Http\Requests\cp\plan;

use Illuminate\Foundation\Http\FormRequest;

class savePlanRequest extends FormRequest
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
            'price'=>'required|numeric',
            'duration'=>'required|numeric',
        ];

        return $rules;

    }
}
