<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\validateLinkRequest;
use App\Http\Requests\global\user\saveUserRequest;
use App\Models\User;
use App\Models\UserRegistrationRequest;
use Illuminate\Http\Request;
use App\Services\UserService;
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

    function ValidateLink(validateLinkRequest $request)
    {

        try {
            if ($request->action === 'verifyUserLogin') {
                $admin = User::where('token', $request->token)->firstOrFail();
                $token = Auth::guard('admin')->loginUsingId($admin->id);
                $payload = [
                    "admin" => $admin,
                    "token" => $token
                ];
            } elseif ($request->action === 'verifyUserRegister') {
                UserRegistrationRequest::where('token', $request->token)->firstOrFail();
                $payload = [];
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
                'message' => $th->message
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
        ], 200);
    }

    function Logout()
    {
    }
}
