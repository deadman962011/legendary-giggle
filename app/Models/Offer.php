<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Offer extends Model
{
    use HasFactory;
    protected $appends=['commission','sales','is_favorite'];
    
    protected $with=['shop'];

    protected $fillable=['name','premalink','start_date','end_date','cashback_amount','thumbnail','shop_id','featured','status','state','isDeleted'];

    public function scopeActive(Builder $query): void
    {
        $query->where('isDeleted', false)->where('state','active')->where('status',true);
    }

    public function scopeNearby($query)
    {   
        $distance=30;
        $request = request();
        $latitude = $request->header('latitude');
        $longitude = $request->header('longitude');
        return $query->whereHas('shop', function ($subquery) use ($latitude, $longitude, $distance) {
            $subquery->selectRaw("
                id,
                latitude,
                longitude,
                (6371 * acos(
                    cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) * sin(radians(latitude))
                )) AS distance",
                [$latitude, $longitude, $latitude])
                ->having("distance", "<", $distance);
        });
    }


    public function scopeInCategory($query,$category) {
        return $query->whereHas('shop.categories', function (Builder $query) use ($category) {
            $query->where('category_id', $category);
        });
    }



    /**
     * Get the shop associated with the Offer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shop()
    {
        return $this->hasOne(Shop::class, 'id', 'shop_id');
    }


    public function translations()
    {
        return $this->hasMany(OfferTranslation::class);
    }

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $translation = $this->translations->where('key', $field)->where('lang',$lang)->first();
        return $translation->value ?? '';
    }


    function getCommissionAttribute() {
        return 0;
    }

    function getSalesAttribute() {
        return 0;
    }

    function getIsFavoriteAttribute(){

        if(Auth::guard('user')->check()){
            $user=Auth::guard('user')->user();
            return OfferFavorite::where('user_id',$user->id)->where('offer_id',$this->id)->count() > 0;
        }
        else{
            return false;
        }


    }



}
