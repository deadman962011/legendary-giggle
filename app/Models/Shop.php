<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class Shop extends Model
{
    use HasFactory;

    protected $appends=['distance'];

    protected $with=['translations','categories'];

    protected $fillable=['shop_name','shop_logo','longitude','latitude','address','tax_register','status','zone_id','district_id','shop_contact_email','shop_contact_phone','shop_contact_website'];

    public function translations()
    {
        return $this->hasMany(ShopTranslation::class);
    }

    public function scopeActive($query)  {
        return $query->where('isDeleted',false)->where('status',true)->whereHas('offers',function($query) {
            return $query->where('isDeleted',false)->where('status',true)->where('state','active');
        });
    }

    /**
     * Get the Categories associated with the Shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function categories()
    {
        return $this->hasOne(ShopCategory::class, 'shop_id', 'id');
    }

    
    /**
     * Get all of the admins for the Shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function admins()
    {
        return $this->hasMany(ShopAdmin::class, 'shop_id', 'id');
    }

    public function getDistanceAttribute()
    {
        $request = request();
        $lat1 = $request->header('latitude');
        $lon1 = $request->header('longitude');


        $lat2 = $this->latitude;
        $lon2 = $this->longitude;

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return round(($miles * 1.609344), 2);
    }


    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $translation = $this->translations->where('key', $field)->where('lang',$lang)->first();
        
        if(!$translation){
            $default_translation=$this->translations->where('key', $field)->where('lang','en')->first();
            return  $default_translation ? $default_translation->value : '';
        }
        return $translation->value;
    }


    /**
     * Get the zone associated with the Shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function zone() 
    {
        return $this->hasOne(Zone::class, 'zone_id', 'id');
    }

    /**
     * Get all of the offers for the Shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offers()
    {
        return $this->hasMany(Offer::class, 'shop_id', 'id');
    }


    /**
     * Get all of the shop_availability for the Shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shop_availability()
    {
        return $this->hasMany(ShopAvailabiltiy::class, 'shop_id', 'id');
    }



}
