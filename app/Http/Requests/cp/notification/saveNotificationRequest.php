<?php

namespace App\Http\Requests\cp\notification;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class saveNotificationRequest extends FormRequest
{


    protected $fetchedLanguages;


    public function __construct()
    {
        parent::__construct();
        $langs = \App\Models\Language::where('status', true)->where('isDeleted', false)->get();
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

        $rules = [];
        foreach ($this->fetchedLanguages as $key => $lang) {
            $rules["title_" . $lang->key] = 'required';
            $rules["description_" . $lang->key] = 'required';
        }

        $rules = [
            // 'image' => 'sometimes|exists:uploads,id',
            'lang.*' => 'required',
            'zone_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value === 'all') {
                        return true;
                    }

                    $zone = \App\Models\Zone::find($value);

                    if (!$zone) {
                        $fail($attribute . ' is invalid.');
                    }
                },
            ]
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
            $messages["title_".$lang->key.".required"] = "notification title in ".$lang->name." is required.";
            $messages["description_".$lang->key.".required"] = "notification description in ".$lang->name." is required.";
        }

        return $messages;
    }


    
}
