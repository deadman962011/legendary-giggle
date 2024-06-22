<?php

namespace App\Http\Resources\merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantRoleDetailsResource extends JsonResource
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
            'role_name_in_arabic'=>$this->getTranslation('name','ar'),
            'role_name_in_english'=>$this->getTranslation('name','en'),
            'permissions'=>$this->permissions->pluck('name')
        ];
    }
}
