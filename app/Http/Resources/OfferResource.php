<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this instanceof \App\Models\Offer){
            $name=$this->getTranslation('name');
        }
        else{
            $name=$this->name;
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
            'thumbnail' => getFileUrl($this->thumbnail),
            'isFavorite'=>$this->isFavorite
        ];
        // return parent::toArray($request);
    }
}
