<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopSubscriptionRequest extends Model
{
    use HasFactory;
 
    protected $fillable=['state','shop_subscription_plan_id','shop_id','sender_full_name','sender_phone_number','sender_bank_name','sender_bank_account_number','sender_bank_iban'];



    /**
     * Get the plan associated with the ShopSubscriptionRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function plan()
    {
        return $this->hasOne(ShopSubscriptionPlan::class, 'id', 'shop_subscription_plan_id');
    }

    /**
     * Get the shop associated with the ShopSubscriptionRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shop()
    {
        return $this->hasOne(Shop::class, 'id', 'shop_id');
    }














}
