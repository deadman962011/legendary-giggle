<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $all_amounts=array_column($this->couponVariations->toArray(), 'amount');
        $min_amount=min($all_amounts);
        $max_amoun=max($all_amounts);

        return [
            'id'=>$this->id,
            'name'=>$this->getTranslation('name'),
            'description'=>$this->getTranslation('description'),
            'refund_details'=>$this->getTranslation('refund_details'),
            'variations'=>$this->couponVariations,
            'min_amount'=>$min_amount,
            'max_amount'=>$max_amoun
        ];

        return parent::toArray($request);
    }
}
