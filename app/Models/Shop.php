<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class Shop extends Model
{
    use HasFactory;

    protected $with=['translations'];

    protected $fillable=['shop_name','shop_logo','longitude','latitude','address','tax_register','status','zone_id'];

    public function translations()
    {
        return $this->hasMany(ShopTranslation::class);
    }

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $translation = $this->translations->where('key', $field)->where('lang',$lang)->first();
        return $translation->value;
    }


}
