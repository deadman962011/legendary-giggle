<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserWalletTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id'=>$this->id,
            'amount'=>$this->amount,
            'type'=>$this->type,
            'reason'=>$this->reason,
            'created_at'=>$this->created_at->format('d/m/Y')
        ]; 
    }
}
