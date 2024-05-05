<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class Setting extends Model
{
    use HasFactory;

    protected $fillable=['value'];

    
    public function translations()
    {
        return $this->hasMany(SettingTranslation::class);
    }


    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $translation = $this->translations->where('key', $field)->where('lang',$lang)->first();
        if(!$translation){
            $default_translation=$this->translations->where('key', $field)->where('lang','en')->first();
            return $default_translation->value;
        }
        return $translation->value;
    }





}
