<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class Coupon extends Model
{
    use HasFactory;
 
    protected $fillable=['name','validity','','thumbnail','category','status','isDeleted'];


    public function scopeActive(Builder $query): void
    {
        $query->where('isDeleted', false)->where('status',true)->whereHas('couponVariations.couponVariationLicences',function($query){
            $query->where('isGranted',false);
        });
    }



    public function translations()
    {
        return $this->hasMany(CouponTranslation::class);
    }

    /**
     * Get all of the CouponVariations for the Coupon
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function CouponVariations()
    {
        return $this->hasMany(CouponVariation::class, 'coupon_id', 'id');
    }


    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $translation = $this->translations->where('key', $field)->where('lang',$lang)->first();
        
        //fallback lang
        if(!$translation){
            $default_translation=$this->translations->where('key', $field)->where('lang','en')->first();
            return $default_translation->value;
        }
        return $translation->value;
    }


}
