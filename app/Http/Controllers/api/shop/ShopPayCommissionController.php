<?php

namespace App\Http\Controllers\api\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\shop\offer\shopPayOfferReqRequest;
use App\Http\Requests\api\shop\shopPayCommission\saveShopPayComissionRequest;
use App\Models\Offer;
use App\Models\ShopPayCommissionRequest;
use App\Models\ShopPayCommissionRequestAttachment;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopPayCommissionController extends Controller
{
    //



    public function List() {
        
    }


    public function Store(saveShopPayComissionRequest  $request)  { 
 
        try {

            DB::beginTransaction();
            // dd($request->all());

            //check if shop has no pending commisison payment request
            $shopPayCommissionRequest = ShopPayCommissionRequest::where('offer_id', $request->offer_id)->where('state', 'pending')->first();
            if ($shopPayCommissionRequest) {
                throw new Error('already_have_pending_request');
            }

            //check selected offer is expired 
            $offer = Offer::where('id', $request->offer_id)->where('state', 'expired')->firstOrFail();

            //check amount is equal to offer commission amount'
            if ($request->amount < $offer->commission) {
                throw new Error('request_amount_should_be_equal_or_greater');
            }
            // 	
            //save commission request 
            $shopPayCommissionRequest = ShopPayCommissionRequest::create([
                'amount'=>$request->amount,
                'offer_id' => $offer->id,
                'sender_full_name' => $request->full_name,
                'sender_phone' => $request->phone,
                'deposit_at'=>strtotime($request->deposit_at),
                'notice' => $request->notice
            ]);

            //save commission request attachments
            $attachments=explode(',',$request->attachments);
             
            foreach ($attachments as $attachment) {
                ShopPayCommissionRequestAttachment::create([
                    'upload_id' => $attachment,
                    'request_id' => $shopPayCommissionRequest->id
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'payload' => null,
                'message' => 'shop pay commission request sent successfully',
            ], 200);
        } catch (\Throwable $th) {

            DB::rollBack();
            $err_message = 'sonthing_went_wrong';
            if ($th->getMessage() === 'request_amount_should_be_equal_or_greater' || $th->getMessage() === 'already_have_pending_request') {
                $err_message = $th->getMessage();
            }

            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => $err_message,
                'debug' => $th->getMessage()
            ], 500);
        }
    }


    
}
