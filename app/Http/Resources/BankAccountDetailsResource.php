<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;


class BankAccountDetailsResource extends JsonResource
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
            'bank_name'=>$this->bank_name,
            'full_name'=>Crypt::decryptString($this->full_name),
            'iban'=>Crypt::decryptString($this->iban),
            'account_number'=>Crypt::decryptString($this->account_number)
        ];
    }
}
