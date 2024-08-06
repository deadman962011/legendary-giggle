<?php

namespace App\Http\Requests\api\shop\shopSubscription;

use Illuminate\Foundation\Http\FormRequest;

class saveShopSubscriptionRequest extends FormRequest
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
            'sender_full_name'=>'required',
            'sender_phone_number'=>'required',
            'sender_bank_name'=>'required',
            'sender_bank_account_number'=>'required',
            'sender_bank_iban'=>'required',
            'plan_id'=>'required|exists:shop_subscription_plans,id',
        ];
    }
}
