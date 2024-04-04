<?php

namespace App\Http\Controllers\api\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\validateLinkRequest;
use App\Http\Requests\global\shop\saveShopRequest;
use App\Mail\ShopMagicLink;
use App\Mail\UserMagicLink;
use App\Models\ShopAdmin;
use App\Models\ShopRegistrationRequest;
use App\Services\ApprovalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;


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

    function Authenticate(Request $request){

        try {

            //check if the shop exists 
            $admin=ShopAdmin::where('email',$request->email)->first();
            
            $token=generate_random_token(6);
            if(!$admin){

                //save store registartion request 
                $saveMagicLink=new ShopRegistrationRequest();
                $saveMagicLink->email=$request->email;
                $saveMagicLink->token=$token;
                $saveMagicLink->save();   
                $action='verifyShopRegister';
            }
            else{
                //update auth token 
                $admin->auth_token=$token;
                $admin->save();
                $action='verifyShopLogin';
            }
            
            //send magic link    
            Mail::to($request->email)->send(new ShopMagicLink($token,$action));
            
            return response()->json([
                'success'=>true,
                'message'=>'magic linl to user email sucessfully sent'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success'=>false,
                'message'=>'Somthing Went Wrong'
            ])->setStatusCode(500);
        }

    
    }


    public function ValidateLink(validateLinkRequest $request) {
        

        try {
            if($request->action==='verifyShopLogin'){
                $admin=ShopAdmin::where('token',$request->token)->firstOrFail();
                $token=Auth::guard('admin')->loginUsingId($admin->id);
                $payload=[
                    "admin"=>$admin,
                    "token"=>$token
                ];
    
    
            }
            elseif($request->action==='verifyShopRegister'){
                ShopRegistrationRequest::where('token',$request->token)->firstOrFail();
                $payload=[];
            }
            else{
                throw new \Exception("action not valid");
            }
 
            return response()->json([
                'success'=>true,
                'payload'=>$payload,
                'message'=>'token is valid'
            ]);
            
        } catch (\Throwable $th) {
            return response()->json([
                'success'=>false,
                'message'=>$th->message
            ]);   
        }

        //



    }

    
    function CompleteRegister(saveShopRequest $request){
     
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
