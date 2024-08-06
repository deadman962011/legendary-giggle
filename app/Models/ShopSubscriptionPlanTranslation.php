<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopSubscriptionPlanTranslation extends Model
{
    use HasFactory;

    protected $fillable=['key','value','lang','shop_id','shop_subscription_plan_id'];

}
