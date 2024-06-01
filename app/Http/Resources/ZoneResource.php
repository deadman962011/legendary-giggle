<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZoneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {


        preg_match('/POINT\((-?\d+\.\d+)-?\s*(-?\d+\.\d+)\)/', $this->center, $matches);
        $longitude = floatval($matches[1]);
        $latitude = floatval($matches[2]);
    

        return [
            'id' => $this->id,
            'name' => $this->getTranslation('name'),
            'center'=>[
                'latitude'=>$latitude,
                'longitude'=>$longitude,
            ]
        ];
        // return parent::toArray($request);
    }
}
