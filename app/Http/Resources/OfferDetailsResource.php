<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class OfferDetailsResource extends JsonResource
{

    protected function getFilteredAvailabilityItems()
    {
        return $this->shop->shop_availability
        ->load(['slots' => function ($query) {
            $query->whereNotNull('start')->whereNotNull('end');
        }]);
        
        
        
        // ->map(function ($item) {
        //     $item->slots = $item->slots()->where('start', '!=', null)->where('end', '!=', null)->get();
        //     return $item;
        // });
    
    }

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
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
            'image' => getFileUrl($this->thumbnail),
            'start_date' => date("m/d/Y", $this->start_date),
            'end_date' => date("m/d/Y", $this->end_date),
            'cashback_amount' => $this->cashback_amount,
            'isFavorite' => $this->isFavorite,
            'days_left' => $this->calculateDaysLeft(),
            'shop' => [
                'longitude' => $this->shop->longitude,
                'latitude' => $this->shop->latitude,
                'shop_contact_email' => $this->shop->shop_contact_email,
                'shop_contact_phone' => $this->shop->shop_contact_phone,
                'availability' => $this->getFilteredAvailabilityItems(),
            ],
            'ratings' => []

        ];
        // return parent::toArray($request);
    }


    private function calculateDaysLeft()
    {
        // Calculate the difference in days between now and the end date
        $now = Carbon::now();
        $end_date = Carbon::createFromFormat('m/d/Y', date("m/d/Y", $this->end_date));
        return $end_date->diffInDays($now);
    }
}
