<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Shop;
use App\Models\OfferTranslation;
use App\Http\Requests\global\offer\saveOfferRequest;

class OfferController extends Controller
{
    //
    public function List(){

        //get categories
        $categories = Offer::where('isDeleted',false)->get();
        return view('category.list',['categories'=>$categories]);

    }

    public function Create(){
        
        //get parent categories
        $shops=Shop::where('isDeleted',false)->where('status',true)->get();
        return view('offer.new',['shops'=>$shops]);

    }
    
    public function Store(saveOfferRequest $request){


        try {
            //save category item
            $saveOffer = new Offer();
            $saveOffer->name=$request->name;
            $saveOffer->premalink=$request->premalink;
            $saveOffer->start_date=$request->start_date;
            $saveOffer->end_date=$request->end_date;
            $saveOffer->cashback_amount=$request->cashback_amount;
            $saveOffer->thumbnail=$request->offer_thumbnail;
            $saveOffer->shop_id=$request->shop_id;
            $saveOffer->save();
            
            //save category translations
            OfferTranslation::create([
                'key'=>'name',
                'value'=>$request->name,
                'lang' => 'en', //default language
                'offer_id' => $saveOffer->id
            ]);

            return response()->json([
                'success'=>true,
                'message'=>'offer successfully saved',
                'action'=>'redirect_to_url',
                'action_val'=>route('offer.list')
            ]);
            
        } catch (\Throwable $th) {
            dd($th);
            return response()->json([
                'success'=>false,
                'message'=>'Somthing Went Wrong'
            ]);
            //throw $th;
        }






    }

    public function Edit(){

    }

    public function Update(Request $request){

    }

    public function Delete(Request $request){

    }




}
