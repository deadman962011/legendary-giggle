<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Http\Requests\api\user\toggleOfferFavoriteRequest;
use App\Models\Offer;
use App\Models\OfferFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiOfferFavoriteController extends Controller
{


    public function Get(Request $request) {
        
        $user=Auth::guard('user')->user();
        $getFavoriteOffers=OfferFavorite::where('user_id',$user->id)->pluck('offer_id');
        $offers=Offer::whereIn('id',$getFavoriteOffers)->where('isDeleted',false)->where('status',true)->paginate(6);

        return response()->json([
            'success'=>true,
            'payload'=>OfferResource::collection($offers)->resource,
            'message'=>'Favorite Offers Successfully Loaded'
        ]);
        


    }


    public function ToggleOfferFavorite(toggleOfferFavoriteRequest $request)  {
        
        $user=Auth::user();

        try {
            
            DB::beginTransaction();
            
            //check first offer is not favorite 
            $hasOfferInFavorite=OfferFavorite::where('user_id',$user->id)->where('offer_id',$request->offer_id)->first();
            if($hasOfferInFavorite){
                $hasOfferInFavorite->delete(); 
            }
            else{
                OfferFavorite::create([
                    'offer_id'=>$request->offer_id,
                    'user_id'=>$user->id
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'payload' => null,
                'message' => $hasOfferInFavorite ? 'Offer Removed From Favorite Successfully' : 'Offer Added To Favorite successfully '
            ], 200);



        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing went wrong',
                'debug'=>$th->getMessage()
            ], 500);
        }
        


    }


    //
}
