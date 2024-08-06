<?php

namespace App\Services;

use App\Models\Referral;
use App\Models\ReferralLog;
use App\Models\User;
use App\Models\UserWallet;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;


class UserService
{
    public function createUser($data)
    { 
       $user= User::create([
            'first_name' => $data['first_name'],
            'last_name'=>$data['last_name'],
            'avatar'=>1,
            'email' => $data['email'],
            // 'phone'=>$data['phone'],
            'birth_date'=>$data['birth_date'],
            'gender'=>$data['gender'],
            'password' => Hash::make(generate_random_token(12)),
            'auth_token'=>generate_random_token(6)
        ]);

        //save user wallet
        UserWallet::create([
            'user_id'=>$user->id
        ]);

        //save user referral
        Referral::create([
            'user_id'=>$user->id,
            'code'=>generate_random_token('6')
        ]);

        //check if has referral save refferal_log item
        if(array_key_exists('referral_code',$data) && $data['referral_code']!=''){
            //get referral item 
            $referral=Referral::where('code',$data['referral_code'])->firstOrFail();
            
            ReferralLog::create([
                'referral_id'=>$referral->id,
                'referral_event'=>'USER_REGISTRATION',
                'model_type'=>'user',
                'model_id'=>$user->id
            ]);
        }

        return $user;

        //


    }

    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    public function updateUser($id, $data)
    {
        $user = $this->getUserById($id);
        $user->update($data);
        return $user;
    }

    public function deleteUser($id)
    {
        $user = $this->getUserById($id);
        // $user->delete();
    }
}
