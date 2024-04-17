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
        return [
            'id' => $this->id,
            'name' => $this->getTranslation('name'),
            'start_date'=>date("m/d/Y",$this->start_date),
            'end_date'=>date("m/d/Y",$this->end_date) ,
            'state'=>'active',
            'sales'=>0,
            'commission'=>0,
            'thumbnail' => getFileUrl($this->thumbnail),
        ];
        // return parent::toArray($request);
    }
}
