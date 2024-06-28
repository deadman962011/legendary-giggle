<?php

namespace App\Http\Resources\merchant;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantStaffDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $role=Role::findById($this->roles[0]->id);

        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'role'=>[
                'id'=>$role->id,
                'name'=>$role->getTranslation('name')
            ]
        ];
        // return parent::toArray($request);
    }
}
