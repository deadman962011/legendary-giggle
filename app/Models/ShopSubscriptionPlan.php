<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ShopSubscriptionPlan extends Model
{
    use HasFactory;


    
    
    protected $fillable = ['name','price','duration','status','isDeleted'];


    protected static function booted(): void
    {
        static::addGlobalScope('removeBasic', function (Builder $builder) {
            $builder->where('id','!=',1);
        });
    }

    public function scopeActive($query)  {
        return $query->where('isDeleted',false)->where('status',true);
    }



    public function translations()
    {
        return $this->hasMany(ShopSubscriptionPlanTranslation::class);
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



}
