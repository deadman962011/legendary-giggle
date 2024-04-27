<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use Illuminate\Http\Request;
use App\Models\Offer;

class ApiOfferController extends Controller
{
    //
    public function Get(Request $request){

        $offers=Offer::active()->paginate(6);

        return response()->json([
            'success'=>true,
            'payload'=>OfferResource::collection($offers)->resource,
            'message'=>'Offers Successfully Loaded'
        ]);

    }

}
