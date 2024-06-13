<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserWalletTransactionResource;
use App\Models\OfferInvoice;
use App\Models\UserWalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiUserWalletController extends Controller
{
    //
    public function Get()
    {

        $user = Auth::guard('user')->user();


        //get user wallet balance
        $available_balance=$user->wallet->balance;

        //get pending user wallet balance
        $pending_balance=OfferInvoice::where('user_id',$user->id)->whereHas('offer',function($query){
            $query->where('state','active')->orWhere(['state'=>'expired','isPaid'=>false]);
        })->sum('amount');

        $total_balance = $available_balance+$pending_balance;


        return response()->json([
            'success' => true,
            'payload' => [
                'pending_balance'=>$pending_balance,
                'available_balance'=>$available_balance,
                'total_balance'=>$total_balance
            ],
            'message' => 'user wallet informations successfully loaded'
        ], 200);
    }


    function GetHistory()
    {

        $user=Auth::guard('user')->user();

        //
        $transactions=UserWalletTransaction::where('wallet_id',$user->wallet->id)->paginate(6);

        return response()->json([
            'success' => true,
            'payload' =>UserWalletTransactionResource::collection($transactions)->resource,
            'message' => 'user wallet translactions successfully loaded'
        ], 200);



    }
}
