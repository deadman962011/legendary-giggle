<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCouponRedeemHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {    
        return [
            'coupon_name'=>$this->Coupon->getTranslation('name'),
            'amount'=>$this->UserWalletTransaction->amount,
            'redeemed_at'=>$this->created_at,
            'state'=>'used'
        ];
    }
}
