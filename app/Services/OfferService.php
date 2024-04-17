<?php

namespace App\Services;
use App\Models\Offer;
use App\Models\OfferTranslation;

class OfferService
{

    
    public function createOffer($data,$from)
    {

        //name	premalink	start_date	end_date	cashback_amount	thumbnail	shop_id	featured	status	isDeleted	created_at	updated_at	
        //save offer
        $offer=Offer::create([
            'name'=> $from==='approval' ? $data->name : $data->{'name_'.$data->lang[0]},
            'premalink'=>generate_random_token('5'),
            'start_date'=>strtotime($data->start_date),
            'end_date'=>strtotime($data->end_date),
            'cashback_amount'=>$data->cashback_amount,
            'thumbnail'=>$data->offer_thumbnail,    
            'shop_id'=>$data->shop_id,
        ]);



        if($from==='approval'){
            //save offer translation
            OfferTranslation::create([
                'key'=>'name',
                'lang'=>'en', //default language
                'value'=>$data->name,
                'offer_id'=>$offer->id
            ]);
        }
        elseif($from==='cp'){
            for ($i=0; $i < count($data->lang); $i++) { 
                OfferTranslation::create([
                    'key'=>'name',
                    'lang'=>$data->lang[$i], //default language
                    'value'=>$data->{"name_".$data->lang[$i]},
                    'offer_id'=>$offer->id
                ]);
            }
        }

    }

}


?>

