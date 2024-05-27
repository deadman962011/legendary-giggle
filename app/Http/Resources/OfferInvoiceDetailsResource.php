<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferInvoiceDetailsResource extends JsonResource
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
            'amount' => $this->amount,
            'vat' => $this->vat,
            'created_at' => $this->created_at,
            'state'=>$this->state,
            'shop' => [
                'id' => $this->offer->shop->id,
                'name'=>$this->offer->shop->getTranslation('name'),
                'tax_register' => $this->offer->shop->tax_register
            ]
        ];

        // return parent::toArray($request);
    }
}
