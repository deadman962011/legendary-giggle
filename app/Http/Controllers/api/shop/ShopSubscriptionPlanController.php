<?php

namespace App\Http\Controllers\api\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\shop\shopSubscription\saveShopSubscriptionRequest;
use App\Http\Resources\merchant\MerchantShopSubscriptionPlanResource;
use App\Models\ShopSubscriptionPlan;
use App\Models\ShopSubscriptionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class ShopSubscriptionPlanController extends Controller
{
    //
    function Get(Request $request)  {
        
        //get plans 

        $plans = ShopSubscriptionPlan::active()->get();

        return response()->json([
            'success' => true,
            'payload' => MerchantShopSubscriptionPlanResource::collection($plans),
            'message' => 'Staff Successfully Loaded'
        ], 200);
    }


    public function Store(saveShopSubscriptionRequest $request) {
    

        $shop=Auth::guard('shop')->user();

        try {

            //check shop has no pending shop subscription request
            $shop_subscription_request = ShopSubscriptionRequest::where('shop_id', $request->shop_id)->where('state', 'pending')->first();
            if ($shop_subscription_request) {
                return response()->json([
                    'success' => false,
                    'payload' => null,
                    'message' => trans('custom.shop_subscription_request_already_sent'),
                ], 200);
            }


            DB::beginTransaction();

            ShopSubscriptionRequest::create([
                'sender_full_name'=>$request->sender_full_name,
                'sender_phone_number'=>$request->sender_phone_number,
                'sender_bank_name'=>$request->sender_bank_name,
                'sender_bank_account_number'=>$request->sender_bank_account_number,
                'sender_bank_iban'=>$request->sender_bank_iban,
                'shop_subscription_plan_id'=>$request->plan_id,
                'shop_id'=>$shop->id,
            ]);

            DB::commit();

            $response_data['success']    =   true;
            $response_data['message']   =  trans('Shop Subscription request successfully sent');
            return response()->json($response_data, 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing Went Wrong',
                'debug' => $th->getMessage()
            ], 500);
        } 
    }
 
}
