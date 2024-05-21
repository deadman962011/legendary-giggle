<?php

namespace App\Http\Requests\cp\notification;

use Illuminate\Foundation\Http\FormRequest;

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
            'image' => 'required|exists:uploads,id',
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
}
