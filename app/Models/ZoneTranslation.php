<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneTranslation extends Model
{
    use HasFactory;

    
    protected $fillable = ['key','value','lang','zone_id'];


}
