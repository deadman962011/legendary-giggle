<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App;

class Zone extends Model
{
    protected $with = ['translations'];

    use HasFactory;

    protected $fillable = [
        'coordinates'
    ];


    public function scopeContains($query,$abc){
        return $query->whereRaw("ST_Distance_Sphere(coordinates, POINT({$abc}))");
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }

    public function translations()
    {
        return $this->morphMany(ZoneTranslation::class, 'translationable');
    }


    public function getTranslation($field = '', $lang = false)
    {
        // $lang = $lang == false ? App::getLocale() : $lang;
        
        $translations = $this->translations->where('lang', $lang)->first();

        return $translations != null ? $translations->$field : $this->$field;
    }



}
