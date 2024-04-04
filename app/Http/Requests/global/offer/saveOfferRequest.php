<?php

namespace App\Http\Requests\global\offer;

use Illuminate\Foundation\Http\FormRequest;

class saveOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required',
            'premalink'=>'required|unique:offers,permalink',
            'start_date'=>'required|numiric',
            'end_date'=>'required|numiric',
            'cashback_amount'=>'required|numiric',
            'shop_id'=>'required|exists:shops,id'
            //
        ];
    }
}
