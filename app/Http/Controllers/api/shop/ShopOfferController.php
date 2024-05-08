<?php

namespace App\Http\Controllers\api\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\offer\saveOfferRequest;
use App\Http\Resources\merchant\MerchantOfferResource;
use App\Models\ApprovalRequest;
use App\Models\Language;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Services\ApprovalService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShopOfferController extends Controller
{

    protected $approvalService;

    public function __construct(ApprovalService $approvalService)
    {
        $this->approvalService = $approvalService;
    }



    function List(Request $request)
    {
        $shop_admin=Auth::guard('shop')->user();

        $offers = Offer::where('shop_id', $shop_admin->shop_id)->where('isDeleted', false)->orderBy('created_at','desc')->get();
        

        //get pending offers 
        $pending_offers= ApprovalRequest::where('action','create')->where('status','pending')->where('model','offer')->where('changes->shop_id',$shop_admin->shop_id)->get();
        $pending_offers=$pending_offers->map(function ($approval_request){
            
            $payload = json_decode($approval_request->changes);
            return (object) [
                'id'=>$approval_request->id,
                'state'=>'pending',
                'sales'=>0,
                'commission'=>0,
                'thumbnail' =>'1',
                'name_ar'=>$payload->name_ar,
                'start_date'=>$payload->start_date,
                'end_date'=>$payload->end_date,
                'cashback_amount'=>$payload->cashback_amount,
                'isFavorite'=>false
            ];
        });

        $collected_pending_offers=collect($pending_offers);
        
        $combined_collection =$collected_pending_offers->concat($offers);

        return response()->json([
            'success' => true,
            'payload' =>MerchantOfferResource::collection($combined_collection),
            'message' => 'Offers Successfully Loaded'
        ], 200);
    }

    function Store(saveOfferRequest $request)
    {

        $data = $request->all();
        $data['start_date'] = strtotime($request->start_date);
        $data['end_date'] = strtotime($request->end_date);
        $data['shop_id']=Auth::guard('shop')->user()->shop_id;
        try {

            DB::beginTransaction();
            $this->approvalService->store('offer', $data);
            DB::commit();
            return response()->json([
                'success' => true,
                'payload' => null,
                'message' => 'Offer registration request successfully saved'
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing went wrong'
            ], 500);
        }
    }

    function Get(Request $request){

        try { 
            $getOffer=Offer::where('id',$request->id)->firstOrFail();
            
            return response()->json([
                'success' => true,
                'payload' =>$getOffer,
                'message' => 'Offers Successfully Loaded'
            ], 200);


        } catch (\Throwable $th) {
            dd($th);
            return response()->json([
                'success' => false,
                'payload' =>null,
                'message' => 'Somthing Went Wrong'
            ], 500);
        };

    }

}