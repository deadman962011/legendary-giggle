<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\user\scanQrRequest;
use App\Http\Resources\OfferInvoiceDetailsResource;
use App\Http\Resources\OfferInvoiceResource;
use App\Models\OfferInvoice;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ApiOfferInvoiceController extends Controller
{
    //
    public function Scan(scanQrRequest $request)
    {

        $user = Auth::guard('user')->user();

        DB::beginTransaction();

        try {
            $decodedPaylaod = preg_replace('/[\x00-\x1F\x7F]/', ',', base64_decode($request->payload));
            $parsedData = explode(',,', $decodedPaylaod);
            $shop_tax_register = $parsedData[2];
            $shop_name = $parsedData[1];
            $invoice_amount = $parsedData[4];
            $invoice_vat = $parsedData[5];

            //check shop is exist
            $shop = Shop::where('tax_register', $shop_tax_register)->first();
            if (!$shop) {
                return response()->json([
                    'success' => false,
                    'payload' => null,
                    'message' => $shop_name . 'shop is not available'
                ], 200);
            }

            //check if shop has active offer
            $offer = $shop->offers()->active()->first();
            if (!$offer) {
                return response()->json([
                    'success' => false,
                    'payload' => null,
                    'message' => trans('custom.no_active_offer_for') . $shop_name
                ], 200);
            }

            //check user dont have invoice for the offer 
            if ($offer->invoices()->where('user_id', $user->id)->count() > 0) {
                return response()->json([
                    'success' => false,
                    'payload' => null,
                    'message' =>  trans('custom.user_already_has_registered_invoice_for_this_offer') 
                ], 200);
            }

            //save offer invoice
            OfferInvoice::create([
                'amount' => $invoice_amount,
                'vat' => $invoice_vat,
                'commission_amout' => $offer->cashback_amount,
                'payload' => $request->payload,
                'user_id' => $user->id,
                'offer_id' => $offer->id
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'payload' => null,
                'message' =>  trans('custom.offer_invoice_successfully_registerd')
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


    public function GetPreviousOffers(Request $request)
    {

        $user = Auth::guard('user')->user();

        $getPreviousOffers = OfferInvoice::where('user_id', $user->id)->with('offer')->paginate(6);

        return response()->json([
            'success' => true,
            'payload' => OfferInvoiceResource::collection($getPreviousOffers)->resource,
            'message' => 'offer invoice request successfully registerd'
        ], 200);
    }


    public function GetOfferInvoice(Request $request)
    {


        $user = Auth::guard('user')->user();

        try {
            $offerInvoice = OfferInvoice::where('user_id', $user->id)->where('id', $request->id)->firstOrFail();

            return response()->json([
                'success' => true,
                'payload' => new OfferInvoiceDetailsResource($offerInvoice),
                'message' => 'offer invoice successfully loaded'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing went wrong',
                'debug' => $th->getMessage()
            ], 500);
        }
    }
}
