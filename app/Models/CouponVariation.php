<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponVariation extends Model
{
    use HasFactory;
 
    protected $fillable=['amount','coupon_id'];


    /**
     * Get all of the CouponVariationLicences f CouponVariation
     *
     * @return \Illuminate\Database\CouponVar   quent\Relations\HasMany
     */
    public function CouponVariationLicences()
    {
        return $this->hasMany(CouponVariationLic::class, 'coupon_variation_id', 'id');
    }


}
