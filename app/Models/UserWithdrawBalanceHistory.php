<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWithdrawBalanceHistory extends Model
{
    use HasFactory;

    protected $table='user_withdraw_balance_history';

    // user_id	withdraw_request_id

    protected $fillable=['user_id','withdraw_request_id'];


    
    /**
     * Get the UserWithdrawBalanceRequest associated with the UserWithdrawBalanceHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function UserWithdrawBalanceRequest()
    {
        return $this->hasOne(UserWithdrawBalanceRequest::class, 'id','withdraw_request_id');
    }



}
