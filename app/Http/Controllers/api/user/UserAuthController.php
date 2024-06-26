<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\validateLinkRequest;
use App\Http\Requests\api\user\saveUserRequest;
use App\Http\Requests\api\user\updateUserAvatar;
use App\Http\Requests\api\user\updateUserProfile;
use App\Mail\UserMagicLink;
use App\Models\User;
use App\Models\UserRegistrationRequest;

use App\Models\Upload;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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



    public function Authenticate(Request $request)
    {

        try {

            //check if the shop exists 
            $admin = User::where('email', $request->email)->first();

            $token = generate_random_token(6);
            if (!$admin) {

                //save store registartion request 
                $saveMagicLink = new UserRegistrationRequest();
                $saveMagicLink->email = $request->email;
                $saveMagicLink->token = $token;
                $saveMagicLink->save();
                $action = 'verifyUserRegister';
            } else {
                //update auth token 
                $admin->auth_token = $token;
                $admin->save();
                $action = 'verifyUserLogin';
            }

            //send magic link    
            Mail::to($request->email)->send(new UserMagicLink($token, $action));

            return response()->json([
                'success' => true,
                'message' => 'magic link to user email sucessfully sent'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Somthing Went Wrong',
                'debug'=>$th->getMessage()
            ], 500);
        }
    }


    function ValidateLink(validateLinkRequest $request)
    {

        try {
            if ($request->action === 'verifyUserLogin') {
                $user = User::where('auth_token', $request->token)->first();
                if ($user) {
                    $user = $user->append('zone');
                    $token = Auth::guard('user')->login($user);
                    $payload = [
                        "user" => $user,
                        "token" => $token
                    ];
                } else {
                    throw new \Exception("somthing went wrong");
                }
            } elseif ($request->action === 'verifyUserRegister') {
                $regRequest = UserRegistrationRequest::where('token', $request->token)->firstOrFail();
                $payload = [
                    'email' => $regRequest->email
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

        try {

            DB::beginTransaction();
            $user = $this->userService->createUser($request->all());
            $user = $user->append('zone');
            //
            $token = auth('user')->login($user);

            DB::commit();
            return response()->json([
                'success' => true,
                'payload' => [
                    'user' => $user,
                    'token' => $token
                ],
                'message' => 'user registration successfully completed'
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing went wrong',
                'debug' => $th->getMessage()
            ], 500);
        }
        // $token = $user->createToken('MyApp')->plainTextToken;


    }

    function Profile(Request $request)
    {

        //get user profile
        return response()->json([
            'success' => true,
            'payload' =>
            Auth::guard('user')->user(),
            'message' => 'user profile successfully loaded'
        ], 200);
    }


    function UpdateProfile(updateUserProfile $request)
    {

        try {

            DB::beginTransaction();

            $user = Auth::guard('user')->user();
            User::where('id', $user->id)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                // 'email'=>$req
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'user profile successfully Updated'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing went wrong',
                'debug' => $th->getMessage()
            ], 500);
        }
    }


    function UpdateProfileImage(Request $request)
    {
        try {
            $user = User::find(auth()->user()->id);
            $type = array(
                "jpg" => "image",
                "jpeg" => "image",
                "png" => "image",
                "svg" => "image",
                "webp" => "image",
                "gif" => "image",
            );
            $image = $request->image;
            $request->filename;
            $realImage = base64_decode($image);
            $dir = public_path('uploads/all');
            $full_path = "$dir/$request->filename";

            $file_put = file_put_contents($full_path, $realImage); // int or false

            if ($file_put == false) {
                return response()->json([
                    'result' => false,
                    'message' => "File uploading error",
                    'path' => ""
                ]);
            }

            $upload = new Upload;
            $extension = strtolower(File::extension($full_path));
            $size = File::size($full_path);

            if (!isset($type[$extension])) {
                unlink($full_path);
                return response()->json([
                    'sucess' => false,
                    'message' => "Only image can be uploaded",
                    'path' => ""
                ]);
            }



            $upload->file_original_name = null;
            $arr = explode('.', File::name($full_path));
            for ($i = 0; $i < count($arr) - 1; $i++) {
                if ($i == 0) {
                    $upload->file_original_name .= $arr[$i];
                } else {
                    $upload->file_original_name .= "." . $arr[$i];
                }
            }

            //unlink and upload again with new name
            unlink($full_path);
            $newFileName = rand(10000000000, 9999999999) . date("YmdHis") . "." . $extension;
            $newFullPath = "$dir/$newFileName";

            $file_put = file_put_contents($newFullPath, $realImage);

            if ($file_put == false) {
                return response()->json([
                    'success' => false,
                    'message' => "Uploading error",
                    'path' => ""
                ]);
            }

            $newPath = "uploads/all/$newFileName";

            $upload->file_original_name = $newPath;
            $upload->extension = $extension;
            $upload->file_name = $newPath;
            $upload->type = $type[$upload->extension];
            $upload->file_size = $size;
            $upload->save();

            $user->avatar = $upload->id;
            $user->save();


            return response()->json([
                'success' => true,
                'message' => __("Image updated"),
                'path' => getFileUrl($upload->id)
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'result' => false,
                'message' => $th->getMessage(),
                'path' => ""
            ]);
        }

    }



    function Logout()
    {
    }
}
