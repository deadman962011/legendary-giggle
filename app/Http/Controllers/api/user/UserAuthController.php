<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\validateLinkRequest;
use App\Http\Requests\api\user\saveUserRequest;
use App\Mail\UserMagicLink;
use App\Models\User;
use App\Models\UserRegistrationRequest;
use Illuminate\Http\Request;
use App\Services\UserService; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
class UserAuthController extends Controller
{
    //
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function Login(Request $request)
    {


        $auth = Auth::guard('user')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if ($auth) {
            return response()->json([
                'sucess' => true,
                'message' => 'user sucessfully logged-in',
                'payload' => [
                    'token' => $auth,
                    'user' => Auth::guard('user')->user()

                ]
            ]);
        } else {
            return response()->json([
                'sucess' => false,
                'message' => 'Creds are wrong'
            ]);
        }
    }



    public function Authenticate(Request $request) {
        
        try {

            //check if the shop exists 
            $admin=User::where('email',$request->email)->first();
            
            $token=generate_random_token(6);
            if(!$admin){

                //save store registartion request 
                $saveMagicLink=new UserRegistrationRequest();
                $saveMagicLink->email=$request->email;
                $saveMagicLink->token=$token;
                $saveMagicLink->save();   
                $action='verifyUserRegister';
            }
            else{
                //update auth token 
                $admin->auth_token=$token;
                $admin->save();
                $action='verifyUserLogin';
            }
            
            //send magic link    
            Mail::to($request->email)->send(new UserMagicLink($token,$action));
            
            return response()->json([
                'success'=>true,
                'message'=>'magic link to user email sucessfully sent'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success'=>false,
                'message'=>'Somthing Went Wrong'
            ],500);
        }
    }


    function ValidateLink(validateLinkRequest $request)
    {

        try {
            if ($request->action === 'verifyUserLogin') {
                $user = User::where('auth_token', $request->token)->first();
                if($user){
                    $token = Auth::guard('user')->login($user);
                    $payload = [
                        "user" => $user,
                        "token" => $token
                    ];
                }
                else{
                    throw new \Exception("somthing went wrong");
                }
            } elseif ($request->action === 'verifyUserRegister') {
                $regRequest = UserRegistrationRequest::where('token', $request->token)->firstOrFail();
                $payload = [
                    'email'=>$regRequest->email
                ];
            } else {
                throw new \Exception("action not valid");
            }

            return response()->json([
                'success' => true,
                'payload' => $payload,
                'message' => 'token is valid'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }


    function CompleteRegister(saveUserRequest $request)
    {
        $user = $this->userService->createUser($request->all());
        //
        $token = auth('user')->login($user);
        // $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json([
            'success' => true,
            'payload' => [
                'user' => $user,
                'token' => $token
            ],
            'message' => 'user registration request successfully saved'
        ], 201);
    }

    function Logout()
    {
    }
}
