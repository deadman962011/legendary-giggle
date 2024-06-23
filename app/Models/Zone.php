<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;
use Illuminate\Support\Facades\App;


class Zone extends Model
{
    use HasFactory;
    use HasSpatial;
 
    protected $casts = [
        'coordinates' => Polygon::class,
    ];


    protected $with = ['translations'];


    protected $fillable = [
        'coordinates',
        'status'
    ];


    public function scopeContains($query,$abc){
        return $query->whereRaw("ST_Distance_Sphere(coordinates, POINT({$abc}))");
    }

    public function scopeActive($query)
    {
        return $query->where('status', true)->where('isDeleted',false);
    }

    public function translations()
    {
        return $this->hasMany(ZoneTranslation::class);
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
