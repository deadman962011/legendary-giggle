<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopWalletTransaction extends Model
{
    use HasFactory;

    protected $fillable=['amount','reason','type','wallet_id'];

}
