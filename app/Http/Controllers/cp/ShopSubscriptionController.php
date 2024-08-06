<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Models\ShopSubscription;
use App\Models\ShopSubscriptionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopSubscriptionController extends Controller
{
    //


    public function List(Request $request)
    {
        //
        $shop_subscription_requests = ShopSubscriptionRequest::when($request->status, function ($query) use ($request) {
            return $query->where('state', $request->status);
        })->get();

        return view('shop_subscription_requests.list', compact('shop_subscription_requests'));
    }


    public function Show(Request $request)
    {

        $shop_subscription_request = ShopSubscriptionRequest::findOrFail($request->id);
        return view('shop_subscription_requests.show', compact('shop_subscription_request'));
    }

    public function Update(Request $request)
    {

        try {
            DB::beginTransaction();
            $shop_subscription_request = ShopSubscriptionRequest::where('id', $request->id)->firstOrFail();

            if ($request->action == 'approve') {

                //add shop subscription to shop
                ShopSubscription::create([
                    'shop_id' => $shop_subscription_request->shop_id,
                    'shop_subscription_plan_id' => $shop_subscription_request->shop_subscription_plan_id,
                    'status' => 'active'
                ]);
            }

            //update subscription request status
            $shop_subscription_request->state = $request->action === 'approve' ? 'approved' : 'rejected';
            $shop_subscription_request->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'payload' => null,
                'action' => 'redirect_to_url',
                'action_val' => route('shop_subscription_request.list', ['status' => $request->action === 'approve' ? 'pending' : '']),
                'message' => 'withdraw_balance_request_' . $request->action
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
}
