<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserWithdrawBalanceHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'amount'=>$this->UserWithdrawBalanceRequest->amount,
            'at'=>$this->created_at,
            'state'=>$this->UserWithdrawBalanceRequest->state
        ];
 
    }
}
