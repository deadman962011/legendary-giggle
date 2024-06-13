<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Models\UserWalletTransaction;
use App\Models\UserWithdrawBalanceRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class UserWithdrawBalanceRequestController extends Controller
{
    //



    public function List(Request $request) { 
         
        $users_withdraw_requests = UserWithdrawBalanceRequest::when($request->status, function ($query) use ($request) {
            return $query->where('state', $request->status);
        })
        ->get();
        return view('user_withdraw_balance_requests.list',compact('users_withdraw_requests'));
    }



    public function Show(Request $request)  {
        
        $users_withdraw_request = UserWithdrawBalanceRequest::findOrFail($request->id);

        return view('user_withdraw_balance_requests.show',compact('users_withdraw_request'));

    }

    public function Update(Request $request){

        try {
            
            DB::beginTransaction();  

            //
            $user_withdraw_request=UserWithdrawBalanceRequest::where('id',$request->id)->firstOrFail();            


            if($request->action=='approve'){

                //reduce user balance amount 
                UserWalletTransaction::create([
                    'amount'=>$user_withdraw_request->amount,
                    'reason'=>'withdraw_balance',
                    'type'=> 'reduce',
                    'wallet_id'=>$user_withdraw_request->user_id
                ]);
            }

            //update withdraw balance state 
            $user_withdraw_request->state= $request->action ==='approve' ? 'approved' : 'rejected';
            $user_withdraw_request->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'payload' => null,
                'action' => 'redirect_to_url',
                'action_val' => route('user_withdraw_balance_request.list',['status'=> $request->action ==='approve' ?'pending' : '']),
                'message' => 'withdraw_balance_request_'.$request->action
            ], 200);


        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing Went Wrong'
            ], 200);
        }
    }
}
