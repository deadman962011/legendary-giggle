<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\user\splitCashbackRequest;
use App\Http\Resources\GetRegisteredContactsResource;
use App\Models\OfferInvoice;
use App\Models\User;
use App\Models\UserSplitCashback;
use App\Models\UserSplitCashbackContact;
use App\Models\UserSplitCashbackContacts;
use App\Models\UserWallet;
use App\Models\UserWalletTransaction;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiSplitCashbackController extends Controller
{
    //
    public function SplitCashback(splitCashbackRequest $request){
        $user = Auth::guard('user')->user();
        // dd($request->all());
        $user_ids=$request->user_ids;
        $cashback_amounts=$request->cashback_amounts;

        $offer_invoice=OfferInvoice::where('user_id',$user->id)->where('offer_id',$request->offer_id)->firstOrFail();
        
        //check offer invoice has no previous split cashback
        $prev_split_cashback=UserSplitCashback::where('offer_invoice_id',$offer_invoice->id)->first();
        if($prev_split_cashback){
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'already_split_cashback'
            ], 500);
        }
        
        
        //check total csahback amounts are equal to offer invoice cashback amount
        $total_cashback_amounts=array_sum($cashback_amounts);
        if($total_cashback_amounts!=$offer_invoice->amount){
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'tota_split_amount_is_not_valid'
            ], 500);
        }


        $reduced_amount=array_sum(array_slice($cashback_amounts, 1)); 
        
        try {

            DB::beginTransaction();

            //save split cashback
            $plit_cashback=UserSplitCashback::create([
                'total_amount' => $total_cashback_amounts,
                'offer_invoice_id' => $offer_invoice->id
            ]);

            for ($i=0; $i < count($user_ids) ; $i++) {                 
    
                $user_ids[$i];
                $cashback_amounts[$i];
    
                if($user_ids[$i]==$user->id){
                    //reduce user wallet amount
                    UserWalletTransaction::create([
                        'amount' => $reduced_amount,
                        'reason' => 'split_cashback',
                        'wallet_id' => $user->wallet->id,
                        'type' => 'reduce'
                    ]);
                }
                else{
                    $split_user=User::find($user_ids[$i]);
                    UserWalletTransaction::create([
                        'amount' => $cashback_amounts[$i],
                        'reason' => 'split_cashback',
                        'wallet_id' => $split_user->wallet->id,
                        'type' => 'increase'
                    ]);

                    UserSplitCashbackContact::create([
                        'amount' => $cashback_amounts[$i],
                        'user_id' => $split_user->id,
                        'split_cashback_id' => $plit_cashback->id
                    ]);
                }
            }

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






        //


    }


    public function GetRegisteredContacts(Request $request){
        
        $fiexed_numbers = [];
         foreach ($request->phone_numbers as $phoneNumber) {
            array_push($fiexed_numbers, $this->formatPhoneNumber($phoneNumber));          
        } 

        //
        $users=User::whereIn('phone', $fiexed_numbers)->get();

        return response()->json([
            'success' => true,
            'payload' => GetRegisteredContactsResource::collection($users)  
        ]);
    }


    function formatPhoneNumber($phoneNumber) { 
 
        $pattern = '/[٠١٢٣٤٥٦٧٨٩\d]/u';
        $mapping = [
            '٠' => '0',
            '١' => '1',
            '٢' => '2',
            '٣' => '3',
            '٤' => '4',
            '٥' => '5',
            '٦' => '6',
            '٧' => '7',
            '٨' => '8',
            '٩' => '9'
        ];
        
        if(preg_match($pattern, $phoneNumber) > 0){
            foreach ($mapping as $arabicNumeral => $englishNumeral) {
                $phoneNumber = str_replace($arabicNumeral, $englishNumeral, $phoneNumber);
            }
        }

        if ($phoneNumber[0] != '+') { 
            $phoneNumber = substr_replace($phoneNumber, '+966', 0, 1);
        }

        $formatted = str_replace(' ', '', $phoneNumber);
      
        return $formatted;
    }
}
