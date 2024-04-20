<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class Offer extends Model
{
    use HasFactory;
    protected $appends=['commission','sales'];
    // id	name	premalink	start_date	end_date	cashback_amount	thumbnail	shop_id	featured	status	isDeleted
    protected $fillable=['name','premalink','start_date','end_date','cashback_amount','thumbnail','shop_id','featured','status','isDeleted'];


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


}
