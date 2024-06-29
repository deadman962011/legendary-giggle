<?php

namespace App\Services;

use App\Models\Language;
use App\Models\Offer;
use App\Models\OfferTranslation;

class OfferService
{

    
    public function createOffer($data,$from)
    {
        
        if($from==='approval'){
            $lang_keys=Language::pluck('key');
            $data->lang=$lang_keys->toArray();
        }

        $offer=Offer::create([
            'name'=> $data->{'name_en'},
            'premalink'=>generate_random_token('5'),
            'start_date'=>$data->start_date,
            'end_date'=>$data->end_date,
            'cashback_amount'=>$data->cashback_amount,
            'thumbnail'=>$data->offer_thumbnail,    
            'shop_id'=>$data->shop_id,
            'status'=>true
        ]);

        for ($i=0; $i < count($data->lang); $i++) { 
            if(isset($data->{"name_".$data->lang[$i]})){
                OfferTranslation::create([
                    'key'=>'name',
                    'lang'=>$data->lang[$i], //default language
                    'value'=>$data->{"name_".$data->lang[$i]},
                    'offer_id'=>$offer->id
                ]);
            } 
        }

        // if($from==='approval'){
        //     //save offer translation
        //     OfferTranslation::create([
        //         'key'=>'name',
        //         'lang'=>'en', //default language
        //         'value'=>$data->name,
        //         'offer_id'=>$offer->id
        //     ]);
        // }
        // elseif($from==='cp'){
        //     for ($i=0; $i < count($data->lang); $i++) { 
        //         OfferTranslation::create([
        //             'key'=>'name',
        //             'lang'=>$data->lang[$i], //default language
        //             'value'=>$data->{"name_".$data->lang[$i]},
        //             'offer_id'=>$offer->id
        //         ]);
        //     }
        // }

    }

}


?>

