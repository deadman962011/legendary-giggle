<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWalletTransaction extends Model
{
    use HasFactory;

    // amount	reason	wallet_id	
    protected $fillable=['amount','reason','type','wallet_id'];

}
