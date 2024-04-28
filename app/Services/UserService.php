<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;


class UserService
{
    public function createUser($data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name'=>$data['last_name'],
            'email' => $data['email'],
            'birth_date'=>$data['birth_date'],
            'gender'=>$data['gender'],
            'password' => Hash::make(generate_random_token(12)),
            'auth_token'=>generate_random_token(6)
        ]);
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
