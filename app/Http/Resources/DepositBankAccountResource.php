<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepositBankAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "id"=> $this->id,
            "bank_name"=>$this->bank_name,
            "full_name"=>$this->full_name,
            "iban"=> $this->iban,
            "account_number"=> $this->account_number,
        ];
        // return parent::toArray($request);
    }
}
