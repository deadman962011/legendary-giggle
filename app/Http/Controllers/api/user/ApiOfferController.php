<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\user\searchOfferRequest;
use App\Http\Resources\OfferDetailsResource;
use App\Http\Resources\OfferResource;
use App\Http\Resources\OfferSearchHistoryResource;
use App\Http\Resources\OfferSearchResource;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Search;
use App\Models\Shop;
use App\Models\ShopTranslation;
use Illuminate\Support\Facades\Auth;

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


    public function Search(searchOfferRequest $request)
    {
 
        $user=Auth::guard('user')->user();
        $translations = ShopTranslation::where('value', 'like', '%' . $request->name . '%')->pluck('shop_id');
        $shops = Shop::query();
        $groupped_offers = $shops->whereIn('id', $translations)->active()->with('offers', function ($query) {
            return $query->where('isDeleted', false)->where('status', true)->where('state', 'active');
        });
        $groupped_offers=$groupped_offers->get();
        
        if($request->filter && $request->filter==='nearby'){
            $groupped_offers=$groupped_offers->sortBy('distance'); 
        }
        
        $mergedOffers = $groupped_offers->flatMap(function ($shop) {
            return $shop->offers;
        });

        if($request->filter && $request->filter==='cashback_amount'){
            $groupped_offers=$groupped_offers->sortBy('cashback_amount'); 
        }
        
        //save search history
        Search::create([
            'query'=>$request->name,
            'user_id'=>$user->id
        ]);
 
        return response()->json([
            'success'=>true,
            'payload'=>OfferSearchResource::collection(paginateCollection($mergedOffers,6))->resource
        ]);

    }

    public function GetSearchHistory(Request $request) {
        

        //
        $user=Auth::guard('user')->user();

        $searches=Search::where('user_id',$user->id)->orderBy('created_at','desc')->limit(6)->get();

        return response()->json([
            'success'=>true,
            'payload'=>OfferSearchHistoryResource::collection($searches),
            'message'=>'search history successfully loaded'
        ]);
        


    }



}
