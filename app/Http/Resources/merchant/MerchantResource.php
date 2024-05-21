<?php

namespace App\Http\Resources\merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantResource extends JsonResource
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
            'shop_name_ar'=>$this->getTranslation('name','ar'),
            'shop_name_en'=>$this->getTranslation('name','en'),
            'shop_contact_email'=>$this->shop_contact_email,
            'shop_contact_phone'=>$this->shop_contact_phone
        ];
        return parent::toArray($request);
    }
}
