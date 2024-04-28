<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'id' => $this->id,
            'name' =>$this->name,
            'slides'=>$this->slides->map(function($slide){
                return [
                    'id'=>$slide->id,
                    'image_url'=>$slide->image_url
                ];
            })
            // 'image_url'=>$this->image_urlP
        ];

    }
}
