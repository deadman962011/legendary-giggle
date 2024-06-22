<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Support\Facades\App;

class Role extends SpatieRole
{

    protected $fillable=['name','guard_name','shop_id'];

    protected $with = ['role_translations'];

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;

        $translation = $this->role_translations->where('key', $field)->where('lang',$lang)->first();
        
        if(!$translation){
            $default_translation=$this->role_translations->where('key', $field)->where('lang','en')->first();
            return  $default_translation ? $default_translation->value : '';
        }
        return $translation->value;
 
    }

    public function role_translations(){
        return $this->hasMany(RoleTranslation::class);
    }
}
