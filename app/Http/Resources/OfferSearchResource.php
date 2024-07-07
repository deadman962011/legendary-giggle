<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class OfferSearchResource extends JsonResource
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
            'name' => $this->shop->getTranslation('name'),
            'cashback_amount' => intval($this->cashback_amount),
            'start_date' => date("m/d/Y", $this->start_date),
            'end_date' => date("m/d/Y", $this->end_date),
            'state' => $this->state,
            'sales' => $this->sales,
            'commission' => $this->commission,
            'thumbnail' => getFileUrl($this->thumbnail),
            'isFavorite' => $this->isFavorite,
            'days_left' => $this->calculateDaysLeft($this->end_date),
            'shop' => [
                'id' => $this->shop->id,
                'name' => $this->getTranslation('name'),
                'distance' => $this->shop->distance,
                'longitude' => $this->shop->longitude,
                'latitude' => $this->shop->latitude
            ]
        ];
    }

    private function calculateDaysLeft($endDate)
    {
        $now = Carbon::now();
        $end_date = Carbon::createFromFormat('m/d/Y', date("m/d/Y", $endDate));
        return $end_date->diffInDays($now);
    }
}
