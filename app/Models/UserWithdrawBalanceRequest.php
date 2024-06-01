<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWithdrawBalanceRequest extends Model
{
    use HasFactory;

    protected $fillable=['amount','bank_account_id','user_id'];


}
