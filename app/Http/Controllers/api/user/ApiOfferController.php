<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferDetailsResource;
use App\Http\Resources\OfferResource;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Shop;
use App\Models\ShopTranslation;

class ApiOfferController extends Controller
{
    //
    public function Get(Request $request)
    {

        $category = $request->category;
        $offers = Offer::active()->nearby();
        if ($category) {
            $offers = $offers->inCategory($category);
        }
        
        //order offers by start_date 
        $offers = $offers->orderByRaw("
            ABS(start_date - UNIX_TIMESTAMP(NOW())) ASC
        ");

        $paginated_offers = $offers->paginate(6);

        return response()->json([
            'success' => true,
            'payload' => OfferResource::collection($paginated_offers)->resource,
            'message' => 'Offers Successfully Loaded'
        ]);
    }

    public function GetOffer(Request $request)
    {

        try {
            $offer = Offer::with(['shop.shop_availability' => function ($query) {
                $query->whereHas('slots', function ($query) {
                    $query->whereNotNull('start')
                        ->whereNotNull('end');
                });
            }])->findOrFail($request->id);
            return response()->json(
                [
                    'success' => true,
                    'payload' => new OfferDetailsResource($offer),
                    'message' => 'Offer Details Successfully Loaded'
                ]
            );
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing went wrong',
                'debug' => $th->getMessage()
            ], 500);
        }
    }


    public function Search(Request $request)  {
        
        $translations = ShopTranslation::where('name', 'like', '%' . $request->name . '%')->pluck('shop_id');
        $shops = Shop::query();
        $groupped_offers =$shops->whereIn('shop_id', $translations)->whereHas('offers',function($query){
            $query->where('status',true)->where('isDeleted',false)->where('state','active'); 
        })->active()->get();



    }


}
