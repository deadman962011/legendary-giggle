<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopWallet extends Model
{
    use HasFactory;

    protected $fillable=['balance','shop_id'];
}
