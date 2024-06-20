<?php

namespace App\Http\Resources\merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantPermissionResource extends JsonResource
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
            'key'=>$this->name,
            'name'=>$this->getTranslation('name')
        ];
        // return parent::toArray($request);
    }
}
