<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\user\scanQrRequest;
use App\Models\OfferInvoice;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ApiOfferInvoiceController extends Controller
{
    //
    public function Scan(scanQrRequest $request) {
        
        $user=Auth::guard('user')->user();
        
        DB::beginTransaction();

        try {
            $decodedPaylaod = preg_replace('/[\x00-\x1F\x7F]/', ',',base64_decode($request->payload));
            $parsedData = explode(',,', $decodedPaylaod);
            $shop_tax_register=$parsedData[2];
            $shop_name=$parsedData[1];
            $invoice_amount=$parsedData[4];
            $invoice_vat=$parsedData[5];
            
            //check shop is exist
            $shop=Shop::where('tax_register',$shop_tax_register)->first();
            if(!$shop){
                return response()->json([
                    'success' => false,
                    'payload' => null,
                    'message' => $shop_name.'shop is not available'
                ], 200);                
            }

            //check if shop has active offer
            $offer=$shop->offers()->active()->first();
            if(!$offer){
                return response()->json([
                    'success' => false,
                    'payload' => null,
                    'message' => 'no active offer for '.$shop_name
                ], 200);
            }

            //check user dont have invoice for the offer 
            if($offer->invoices()->where('user_id',$user->id)->count() > 0){
                return response()->json([
                    'success' => false,
                    'payload' => null,
                    'message' => 'user alraedy has invoice for this offer '
                ], 200);
            }
            
            //save offer invoice
            OfferInvoice::create([
                'amount'=>$invoice_amount,
                'vat'=>$invoice_vat,
                'commission_amout'=>$offer->cashback_amount,
                'payload'=>$request->payload,
                'user_id'=>$user->id,
                'offer_id'=>$offer->id
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'payload' => null,
                'message' => 'offer invoice request successfully registerd'
            ], 200);
        
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing went wrong'
            ], 500);
        }    




        












    }






}
