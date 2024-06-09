<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Models\ShopPayCommissionRequest;
use App\Models\UserWalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopPayCommissionAmountController extends Controller
{
    //
    public function List(Request $request) {
        
        //
        $shop_pay_commission_requests=ShopPayCommissionRequest::when($request->status, function ($query) use ($request) {
            return $query->where('state', $request->status);
        })->get();

        return view('shop_pay_commission_requests.list',compact('shop_pay_commission_requests'));
    }


    public function Show(Request $request) {
        
        $shop_pay_commission_request=ShopPayCommissionRequest::findOrFail($request->id);
        return view('shop_pay_commission_requests.show',compact('shop_pay_commission_request'));
    }

    public function Update(Request $request){

        try {
            
            DB::beginTransaction();  

            //
            $shop_pay_commission_request=ShopPayCommissionRequest::where('id',$request->id)->firstOrFail();            

            if($request->action=='approve'){

                //add points to every user 
                $shop_pay_commission_request->offer->invoices->map(function($invoice){
                    UserWalletTransaction::create([
                        'amount'=>$invoice->points,
                        'reason'=>'offer '. $invoice->offer->getTranslation('name') .' cashback',
                        'type'=> 'increase',
                        'wallet_id'=>$invoice->user->wallet->id
                    ]);
                });

                //update offer status 
                $offer=$shop_pay_commission_request->offer;
                $offer->update([
                    'isPaid'=>true,
                    'status'=>false,
                    'paid_at'=>now(),
                ]);
            }

            //update withdraw balance state 
            $shop_pay_commission_request->state= $request->action ==='approve' ? 'approved' : 'rejected';
            $shop_pay_commission_request->reason=$request->action ==='rejected' ?  $request->reason : '';
            $shop_pay_commission_request->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'payload' => null,
                'action' => 'redirect_to_url',
                'action_val' => route('shop_commission_payment.list'),
                'message' => 'shop_pay_commission_request_'.$request->action
            ], 200);


        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing Went Wrong',
                'debug'=>$th->getMessage()
            ], 200);
        }
    }


        // public function Update(Request $request)  {
        

    //     //






    // }





}
