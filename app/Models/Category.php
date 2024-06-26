<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class Category extends Model
{
    use HasFactory;


    protected $fillable=['status','isDeleted'];

    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
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


    public function scopeActive(Builder $query): void
    {
        $query->where('isDeleted', false)->where('status',true);
    }

}
