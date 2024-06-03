<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWithdrawBalanceRequest extends Model
{
    use HasFactory;

    protected $fillable=['amount','bank_account_id','user_id'];


    /**
     * Get the User associated with the UserWithdrawBalanceRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function User() 
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get the BankAccount associated with the UserWithdrawBalanceRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function BankAccount()
    {
        return $this->hasOne(BankAccount::class, 'id', 'bank_account_id');
    }


}
