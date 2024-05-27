<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\user\saveBankAccountRequest;
use App\Http\Resources\BankAccountDetailsResource;
use App\Http\Resources\BankAccountResource;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class ApiBankAccountController extends Controller
{
    //


    public function Get()
    {

        $user = Auth::guard('user')->user();
        $bank_accounts = BankAccount::active()->where('user_id', $user->id)->get();
        return response()->json([
            'success' => true,
            'payload' => BankAccountResource::collection($bank_accounts),
            'message' => 'Bank Accounts Successfully Loaded'
        ]);
    }

    function GetBankAccountDetails(Request $request)
    {
        try {
            $user = Auth::guard('user')->user();
            $bank_account = BankAccount::active()->where('user_id', $user->id)->where('id', $request->id)->firstOrFail();
            return response()->json([
                'success' => true,
                'payload' => new BankAccountDetailsResource($bank_account),
                'message' => 'Bank Account Successfully Loaded'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing went wrong',
                'debug' => $th->getMessage()
            ]);
        }
    }

    public function Store(saveBankAccountRequest $request)
    {

        try {

            DB::beginTransaction();
            $user = Auth::guard('user')->user();
            BankAccount::create([
                'bank_name' => $request->bank_name,
                'full_name' => Crypt::encryptString($request->full_name),
                'iban' => Crypt::encryptString($request->iban),
                'account_number' => Crypt::encryptString($request->account_number),
                'user_id' => $user->id
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'payload' => null,
                'message' => 'Bank Account Successfully created'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing went wrong',
                'debug' => $th->getMessage()
            ]);
        }
    }


    function Update(saveBankAccountRequest $request)
    {
        try {

            DB::beginTransaction();
            $user = Auth::guard('user')->user();
            $bank_account = BankAccount::where('user_id',$user->id)->where('id',$request->id)->firstOrFail();
            
            $bank_account->update([
                'bank_name' => $request->bank_name,
                'full_name' => Crypt::encryptString($request->full_name),
                'iban' => Crypt::encryptString($request->iban),
                'account_number' => Crypt::encryptString($request->account_number),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'payload' => null,
                'message' => 'Bank Account Successfully update'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing went wrong',
                'debug' => $th->getMessage()
            ]);
        }
    }
}
