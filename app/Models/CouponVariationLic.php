<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponVariationLic extends Model
{
    use HasFactory;

    // key	status	coupon_variation_id
    protected $fillable=['key','status','isGranted','coupon_variation_id'];


}
