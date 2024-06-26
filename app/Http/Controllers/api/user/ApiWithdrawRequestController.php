<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\user\saveWithdrawReqRequest;
use App\Http\Resources\UserWithdrawBalanceHistoryResource;
use App\Models\UserWithdrawBalanceHistory;
use App\Models\UserWithdrawBalanceRequest;
use App\Notifications\cp\UserWithdrawRequestSaved;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiWithdrawRequestController extends Controller
{
    //


    public function Store(saveWithdrawReqRequest $request) {
        
        
        $user=Auth::guard('user')->user();

        try {

            //check withdraw amount is not greater than the minimum amount
            $minimum_amount = getSetting('user_minimum_withdraw_amount');
            if($minimum_amount > $request->amount){
                throw  new Error('minimum_amount_to_withdraw');
            }

            //check user has the required amount
            if($request->amount > $user->wallet->balance){
                throw new Error('no_enough_balance');
            }

            //check user has no pending withdraw blance request
            $withdraw_request = UserWithdrawBalanceRequest::where('user_id',$user->id)->where('state','pending')->count();
            if($withdraw_request > 0){
                throw new Error('already_has_pending_withdraw_balance');
            }

            DB::beginTransaction();

            //save user withdraw request
            $withdrawRequest=UserWithdrawBalanceRequest::create([
                'amount'=>$request->amount,
                'bank_account_id'=>$request->bank_account_id,
                'user_id'=>$user->id
            ]);
    
            //save withdraw request history
            UserWithdrawBalanceHistory::create([
                'user_id'=>$user->id,
                'withdraw_request_id'=>$withdrawRequest->id
            ]);
     
            //send notification to admins 
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'user withdraw request successfully saved'
            ], 200);            
            

        } catch (\Throwable $th) {
            
            $err_message=$th->getMessage();
            if($err_message === 'minimum_amount_to_withdraw' ){
                $err_message=trans('custom.minimum_amount_to_withdraw').' '.getSetting('user_minimum_withdraw_amount');;
            } 
            else if($err_message === 'no_enough_balance'){
                $err_message=trans('custom.no_enough_balance');
            }
            else if($err_message === 'already_has_pending_withdraw_balance'){
                $err_message=trans('custom.already_has_pending_withdraw_balance');
            }
            else{
                $err_message= trans('custom.somthing_went_wrong');
            }

            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $err_message,
                'debug'=>$th->getMessage()
            ], 500);
        }
    }





    public function GetWithdrawBalanceRequestHistory(Request $request) {
        
        //
        $user=Auth::guard('user')->user();

        $withdraw_request_history=UserWithdrawBalanceHistory::where('user_id',$user->id)->paginate(6);

        return response()->json([
            'success' => true,
            'payload'=> UserWithdrawBalanceHistoryResource::collection($withdraw_request_history)->resource,
            'message' => 'user withdraw request successfully saved'
        ], 200);


    }



}
