<?php

namespace App\Http\Resources\merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantOfferDetails extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [

            'id' => $this->id,
            'name' => $this->getTranslation('name'),
            'cashback_amount'=> intval($this->cashback_amount),
            'start_date'=>date("m/d/Y",$this->start_date),
            'end_date'=>date("m/d/Y",$this->end_date) ,
            'state'=>$this->state,
            'sales'=>$this->sales,
            'commission_amount_percentage'=>$this->commission_amount_percentage,
            'commission'=>$this->commission,
            'beneficiaries'=>$this->invoices->map(function($invoice){
                return [
                    'id'=>$invoice->id,
                    'amount'=>$invoice->amount,
                    'name'=>$invoice->user->first_name.' '.$invoice->user->last_name,
                    'state'=>$invoice->state,
                    'created_at'=>$invoice->created_at,
                ];
            }),
            'beneficiaries_count'=>$this->invoices->count(),

        ];


        // return parent::toArray($request);
    }
}
