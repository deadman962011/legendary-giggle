<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Permission extends Model
{
  //

  public function translations()
  {
      return $this->hasMany(PermissionTranslation::class);
  }

  public function getTranslation($field = '', $lang = false)
  {
      $lang = $lang == false ? App::getLocale() : $lang;
      $translation = $this->translations->where('key', $field)->where('lang',$lang)->first();
      return $translation->value ?? '';
  }


}
