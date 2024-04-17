<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Http\Requests\cp\admin\adminLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function Get(){
        return view('vendor.adminlte.auth.login');
    }

    public function Post(adminLoginRequest $request){

        $attempt=Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password]);
        if($attempt){
            return response()->json([
                'success'=>true,
                'message'=>'successfully logged-in',
                'action'=>'redirect_to_url',
                'action_val'=>route('home')
            ]);
        }

        return response()->json([
            'success'=>false,
            'message'=>'Credentials does not match.'
        ]);

    }
    


}
