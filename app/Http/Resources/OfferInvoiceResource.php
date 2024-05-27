<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferInvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'points'=>$this->points,
            'state'=>$this->state,
            'paid_at'=>$this->offer->paid_at,
            'shop_name'=>$this->offer->shop->getTranslation('name'),
            'isRewardDivided'=>false,
            'rewardDividedUsers'=>[]
        ];




    }
}
