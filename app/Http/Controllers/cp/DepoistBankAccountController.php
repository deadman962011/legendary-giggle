<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Http\Requests\cp\deposit_bank_account\saveDepositBankAccount;
use Illuminate\Http\Request; 
use App\Models\Shop; 
use App\Models\DepositBankAccount;
use Illuminate\Support\Facades\DB;
class DepoistBankAccountController extends Controller
{ 
    public function __construct( )
    { 

        // Staff Permission Check
        $this->middleware(['permission:display_deposit_bank_accounts','permission:edit_deposit_bank_account','permission:delete_deposit_bank_account'])->only('List');
        $this->middleware(['permission:add_deposit_bank_account'])->only(['Create','Store']);
        $this->middleware(['permission:edit_deposit_bank_account'])->only(['Edit','Update']);
        $this->middleware(['permission:delete_deposit_bank_account'])->only('Delete');


    }

    //
    public function List(){

        //get categories
        $depositBankAccounts = DepositBankAccount::where('isDeleted',false)->get();
        return view('deposit_bank_account.list',['depositBankAccounts'=>$depositBankAccounts]);

    }

    public function Create(){
         
        return view('deposit_bank_account.new');

    }
    
    public function Store(saveDepositBankAccount $request){
 
        try {

            DB::beginTransaction();        
 
            DepositBankAccount::create([
                'bank_name'=>$request->bank_name,
                'full_name'=>$request->full_name,
                'iban'=>$request->iban,
                'account_number'=>$request->account_number
            ]); 
            
            DB::commit();

            return response()->json([
                'success'=>true,
                'message'=>'deposit bank account successfully saved',
                'action'=>'redirect_to_url',
                'action_val'=>route('deposit_bank_account.list')
            ]);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success'=>false,
                'message'=>'Somthing Went Wrong',
                'debug'=>$th->getMessage()
            ]);
        }
    }

    public function Edit(){

    }
    

    public function Update(Request $request){

    }

    function UpdateStatus(Request $request)  {
        
        $updateDepositBankAccount=DepositBankAccount::findOrFail($request->id);
        $updateDepositBankAccount->update([
            'status'=>!$updateDepositBankAccount->status
        ]);
        
        return response()->json([
            'success'=>true,
            'message'=>__('deposit_bank_account_status_successfully_updated')
        ],200);

    }


    public function Delete(Request $request){

        $deleteDepositBankAccount=DepositBankAccount::findOrFail($request->id);

        //update category
        $deleteDepositBankAccount->update([
            'isDeleted'=>true
        ]);

        return response()->json([
            'success'=>true,
            'action'=>'redirect_to_url',
            'action_val'=>route('deposit_bank_account.list'),
            'message'=>__('deposit_bank_account_successfully_deleted')
        ],200);

    }
}












 