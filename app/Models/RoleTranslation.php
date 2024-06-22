<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleTranslation extends Model
{
    protected $fillable = ['key','value', 'lang', 'role_id'];

    public function role(){
      return $this->belongsTo(Role::class);
    }
}
