<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\shop\offer\shopPayOfferReqRequest;
use App\Http\Resources\DepositBankAccountResource;
use App\Models\DepositBankAccount;



class ApiDepositBankAccountController extends Controller
{
    //
    public function Get()
    {

        //get categories
        $depositBankAccounts = DepositBankAccount::active()->get();

        return response()->json([
            'success' => true,
            'payload' => DepositBankAccountResource::collection($depositBankAccounts)
        ]);
    }
 
}
