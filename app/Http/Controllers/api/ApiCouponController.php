<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\user\redeemCouponRequest;
use App\Http\Resources\CouponDetailsResource;
use App\Http\Resources\CouponResource;
use App\Http\Resources\UserCouponRedeemHistory as ResourcesUserCouponRedeemHistory;
use App\Http\Resources\UserCouponRedeemHistoryResource;
use App\Models\Coupon;
use App\Models\CouponVariation;
use App\Models\CouponVariationLic;
use App\Models\UserCouponRedeemHistory;
use App\Models\UserWalletTransaction;
use Error;
use Illuminate\Container\RewindableGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ApiCouponController extends Controller
{
    //
    public function Get(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'category' => 'sometimes|in:onsite,online,',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validation_error',
            ], 422);
        }


        $coupons = Coupon::active()->when($request->category, function ($query) use ($request) {
            return $query->where('category', $request->category);
        })->paginate(6);

        return response()->json(
            [
                'success' => true,
                'payload' => CouponResource::collection($coupons)->resource,
                'message' => 'Coupons Successfully Loaded'
            ]
        );
    }


    public function GetCouponRedeemHistory(Request $request){

        $user=Auth::guard('user')->user();

        $coupons_redeem_history=UserCouponRedeemHistory::where('user_id',$user->id)->paginate(6);

        return response()->json(
            [
                'success' => true,
                'payload' => UserCouponRedeemHistoryResource::collection($coupons_redeem_history)->resource,
                'message' => 'user coupons redeem successfully loaded',
                // 'debug'=>$th->getMessage()
            ]
        );
    }


    public function GetCouponDetails(Request $request)
    {
        try {
            $coupon = Coupon::active()->where('id', $request->id)->firstOrFail();
            return response()->json(
                [
                    'success' => true,
                    'payload' => new CouponDetailsResource($coupon),
                    'message' => 'Coupons Successfully Loaded'
                ]
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'success' => false,
                    'payload' => null,
                    'message' => 'Somthing went wrong',
                    'debug'=>$th->getMessage()
                ]
            );
        }
    }

    public function RedeemCoupon(redeemCouponRequest $request) {
        
        //
        $user=Auth::guard('user')->user();
         

        try {
            DB::beginTransaction();

            $coupon_variation=CouponVariation::where('coupon_id',$request->id)->where('id',$request->coupon_variation_id)->firstOrFail();

            //update coupon licence granted
            $coupon_lics=CouponVariationLic::where('coupon_variation_id',$coupon_variation->id)->where('isGranted',false)->get();
            if($coupon_lics->count() < $request->quantity){
                throw new Error('no_avaiable_quantity');
            }
            foreach ($coupon_lics as $key => $coupon_lic) {
                $coupon_lic->update([
                    'isGranted'=>true
                ]);

                //save user wallet transaction 		
                $transaction=UserWalletTransaction::create([
                    'amount'=>$coupon_lic->CouponVariation->amount,
                    'reason'=>'redeem_coupon',
                    'type'=> 'reduce',
                    'wallet_id'=>$user->wallet->id
                ]);
                
                //save coupon redeem history 
                UserCouponRedeemHistory::create([
                    'user_id'=>$user->id,
                    'coupon_id'=>$coupon_lic->CouponVariation->Coupon->id,
                    'coupon_variation_lic_id'=>$coupon_lic->CouponVariation->id,
                    'user_wallet_transaction_id'=>$transaction->id
                ]);
                            
            }

            DB::commit();
        
            return response()->json([
                'success' => true,
                'payload' => null,
                'message' => 'coupon successfully redeemed'
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            $err_message='sonthing_went_wrong';
            if($th->getMessage() ==='no_avaiable_quantity'){
                $err_message=$th->getMessage();
            }
            
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' =>trans('custom.'.$err_message),
                'debug'=>$th->getMessage()
            ], 500);
        }
    }





}
