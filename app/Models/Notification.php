<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Notification extends Model
{
    use HasFactory;

    // title	description 	image	status	created_at	updated_at	
    protected $fillable=['title','description','image'];



    public function translations()
    {
        return $this->hasMany(NotificationTranslation::class);
    }

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $translation = $this->translations->where('key', $field)->where('lang',$lang)->first();
        return $translation->value ?? '';
    }



}
