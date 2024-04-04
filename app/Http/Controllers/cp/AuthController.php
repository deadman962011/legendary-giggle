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
        return view('auth.login');
    }

    public function Post(adminLoginRequest $request){

        $attempt=Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password]);
        if($attempt){
            return redirect()->to('/');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors(['Credentials does not match.']);

    }
    


}
