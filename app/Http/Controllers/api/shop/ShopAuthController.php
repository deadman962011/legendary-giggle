<?php

namespace App\Http\Controllers\api\shop;

use App\Http\Controllers\Controller;
use App\Mail\ShopMagicLink;
use App\Mail\UserMagicLink;
use App\Models\ShopRegistrationRequest;
use App\Services\ApprovalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ShopAuthController extends Controller
{
    //
    protected $approvalService;

    public function __construct(ApprovalService $approvalService)
    {
        $this->approvalService = $approvalService;
    }

    public function Login(Request $request){
        
    }


    function Register(Request $request) {
        
        
        try {
            $token=generate_random_token(6);
            //save store registartion request 
            $saveMagicLink=new ShopRegistrationRequest();
            $saveMagicLink->email=$request->email;
            $saveMagicLink->token=$token;
            $saveMagicLink->save();
            //send magic link    
            Mail::to($saveMagicLink->email)->send(new ShopMagicLink($token));
            
            return response()->json([
                'success'=>true,
                'message'=>'magic linl to user email sucessfully sent'
            ]);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json([
                'success'=>false,
                'message'=>'Somthing Went Wrong'
            ]);
        }



    }


    function CompleteRegister(Request $request){
     
        $data=$request->all();
        $data['shop_logo']='1';        

        // if($request->shop_logo){

        // }

        //save shop approval request 
        $this->approvalService->store('shop',$data);


        return response()->json([
            'success'=>true,
            'payload'=>null,
            'message'=>'shop registration request successfully saved'
        ],201);





    }

    


}
