<?php

namespace App\Http\Resources\merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantOfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {   
        if($this->resource instanceof \App\Models\Offer){
            $name=$this->getTranslation('name');
        }
        else{
            $name=$this->name_ar;
        }

        return [
            'id' => $this->id,
            'name' => $name,
            'cashback_amount'=> intval($this->cashback_amount),
            'start_date'=>date("m/d/Y",$this->start_date),
            'end_date'=>date("m/d/Y",$this->end_date) ,
            'state'=>$this->state,
            'sales'=>$this->sales,
            'commission'=>$this->commission,
        ];

        // return parent::toArray($request);
    }
}
