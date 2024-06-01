<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCouponRedeemHistory extends Model
{
    use HasFactory;
    protected $table = 'user_coupon_redeem_history';
 
    protected $fillable=['user_id','coupon_id','coupon_variation_lic_id','user_wallet_transaction_id'];


    /**
     * Get the Coupon associated with the UserCouponRedeemHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Coupon()
    {
        return $this->hasOne(Coupon::class, 'id', 'coupon_id');
    }

    /**
     * Get the UserWalletTransaction associated with the UserCouponRedeemHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function UserWalletTransaction()
    {
        return $this->hasOne(UserWalletTransaction::class, 'id', 'user_wallet_transaction_id');
    }



}
