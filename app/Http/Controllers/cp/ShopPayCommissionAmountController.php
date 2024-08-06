<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Models\ShopConnectedUser;
use App\Models\ShopPayCommissionRequest;
use App\Models\ShopWalletTransaction;
use App\Models\UserWalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopPayCommissionAmountController extends Controller
{
    //
    public function List(Request $request)
    {

        //
        $shop_pay_commission_requests = ShopPayCommissionRequest::when($request->status, function ($query) use ($request) {
            return $query->where('state', $request->status);
        })->get();

        return view('shop_pay_commission_requests.list', compact('shop_pay_commission_requests'));
    }


    public function Show(Request $request)
    {

        $shop_pay_commission_request = ShopPayCommissionRequest::findOrFail($request->id);
        return view('shop_pay_commission_requests.show', compact('shop_pay_commission_request'));
    }

    public function Update(Request $request)
    {

        try {

            DB::beginTransaction();

            //
            $shop_pay_commission_request = ShopPayCommissionRequest::where('id', $request->id)->firstOrFail();

            if ($request->action == 'approve') {

                //add points to every user 
                $offer = $shop_pay_commission_request->offer;
                $invoices = $shop_pay_commission_request->offer->invoices->where('isCanceled', false);
                $fcm_tokens=[];
                $invoices->map(function ($invoice) use ($offer,&$fcm_tokens) {

                    //add points to user wallet
                    UserWalletTransaction::create([
                        'amount' => $invoice->points,
                        'reason' => 'offer ' . $invoice->offer->getTranslation('name') . ' cashback',
                        'type' => 'increase',
                        'wallet_id' => $invoice->user->wallet->id
                    ]);
                    array_push($fcm_tokens, $invoice->user->fcm_token);

                    //bonus to shop
                    if ($offer->shop->is_premium) {
                        if (!$invoice->user->ShopConnection) {
                            ShopConnectedUser::create([
                                'user_id' => $invoice->user->id,
                                'shop_id' => $offer->shop->id
                            ]);
                        } else {
                            //add balance to connected shop wallet 
                            if (getSetting('connected_user_shop_bonus_approved_offer_invoice_status') > 0) {

                                $shop_wallet_id = $invoice->user->ShopConnection->shop_id;
                                $percentage = getSetting('connected_user_shop_bonus_amount_approved_offer_invoice');
                                $bonusAmount = ($invoice->amount * $percentage) / 100;

                                //calculate shop bonus
                                ShopWalletTransaction::create([
                                    'amount' => $bonusAmount,
                                    'reason' => ' connected user approved offer invoice bonus',
                                    'type' => 'increase',
                                    'wallet_id' => $shop_wallet_id
                                ]);
                            }
                        }
                    }
                });

                //update offer status                 
                $offer->update([
                    'isPaid' => true,
                    'status' => false,
                    'paid_at' => now(),
                ]);

                $invoices = $shop_pay_commission_request->offer->invoices->where('isCanceled', false);
 
            }

            //update withdraw balance state 
            $shop_pay_commission_request->state = $request->action === 'approve' ? 'approved' : 'rejected';
            $shop_pay_commission_request->reason = $request->action === 'rejected' ?  $request->reason : '';
            $shop_pay_commission_request->save();

            $notification_data=[
                'title' =>    'user_got_cashback',
                'description' => '25_cashback_added_to_your_wallet',
                'image' => '',
                'target' => 'user',
                'offer_id'=>$offer->id,
                'cashback_amount'=>0
            ];

            
            //send notification to every user
            send_push_notif_to_multiple_users($notification_data,$fcm_tokens,'cashback_recived');



            DB::commit();
            return response()->json([
                'success' => true,
                'payload' => null,
                'action' => 'redirect_to_url',
                'action_val' => route('shop_commission_payment.list', ['status' => 'pending']),
                'message' => 'shop_pay_commission_request_' . $request->action
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing Went Wrong',
                'debug' => $th->getMessage()
            ], 200);
        }
    }


    // public function Update(Request $request)  {


    //     //






    // }





}
