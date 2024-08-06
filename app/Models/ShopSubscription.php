<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopSubscription extends Model
{
    use HasFactory;

    protected $fillable=['status','shop_subscription_plan_id','shop_id'];

    
}
