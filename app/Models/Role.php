<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $with = ['role_translations'];


    protected static function boot()
    {
        parent::boot();
        static::creating(function($model){
            static::makeSureRoleNameUnique($model);
        });
        static::saved(function($model){
            static::updateDefaultRoleTranslations($model);
        });
    }

    /**
     * Setting the creating event data so we can modify the data when inserting
     * Role Name must be unique. if not it will be appended with counter.
     */
    protected static function makeSureRoleNameUnique($model)
    {
        $is_role_name_unique    =   self::isRoleNameUique($model->name);
        $counter                =   1;
        $new_name               =   $model->name;
        while(!$is_role_name_unique)
        {
            $new_name               =   $model->name . '_' . $counter++;
            $is_role_name_unique    =   self::isRoleNameUique($new_name);
        }
        $model->name    =   $new_name;
    }

    protected static function isRoleNameUique($name) : bool
    {
        return  !(self::query()->whereName($name)->exists() || RoleTranslation::query()->whereName($name)->exists());
    }


    /**
     * Update Role Translation If it's belong to a shop and one of a branch default roles
     */
    protected static function updateDefaultRoleTranslations($model)
    {
        if(!RoleTranslation::query()->where('role_id' , $model?->id)->exists())
        {
            $default_role_names                         =   ['branch product manager','branch admin','branch operator','branch pickup manager'];
            $default_role_names_ar_translations            =   ['مدير منتجات ','مسؤول ','مدير العمليات ','مسؤول نقطة الالتقاط '];
            $model_role_name                            =   @end(explode('-' , $model->name)); //the last segment which contains the role name.
            foreach($default_role_names as $key => $default_role_name)
            {
                if(str_contains($model_role_name  , $default_role_name))
                {
                    $shop           =   Shop::query()->find($model->shop_id);
                    $shop_ar_name   =    $shop->getTranslation('name' , 'sa');
                    $shop_en_name   =    $shop->getTranslation('name' , 'en');
                    RoleTranslation::query()->updateOrCreate(
                        [
                            'role_id'       =>  $model->id,
                            'lang'          =>  'sa',
                        ] ,
                        [
                            'role_id'       =>  $model->id,
                            'lang'          =>  'sa',
                            'name'          =>  $shop_ar_name.' - '.$default_role_names_ar_translations[$key],
                        ]
                    );
                    RoleTranslation::query()->updateOrCreate(
                        [
                            'role_id'       =>  $model->id,
                            'lang'          =>  'en',
                        ] ,
                        [
                            'role_id'       =>  $model->id,
                            'lang'          =>  'en',
                            'name'          =>  $shop_en_name.'  - '.$default_role_name,
                        ]
                    );
                }
            }
        }
    }

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $role_translation = $this->role_translations->where('lang', $lang)->first();
        return $role_translation != null ? $role_translation->$field : $this->$field;
    }

    public function role_translations(){
        return $this->hasMany(RoleTranslation::class);
    }
}
