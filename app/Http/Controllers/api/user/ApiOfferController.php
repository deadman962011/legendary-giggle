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

        $category=$request->category;
        $offers=Offer::active()->nearby();
        if($category){
            $offers=$offers->inCategory($category);
        }
        $paginated_offers=$offers->paginate(6);

        return response()->json([
            'success'=>true,
            'payload'=>OfferResource::collection($paginated_offers)->resource,
            'message'=>'Offers Successfully Loaded'
        ]);

    }

}
