<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $with=['slides'];

    /**
     * Get all of the Slides for the Slider
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Slides() 
    {
        return $this->hasMany(Slide::class, 'slider_id', 'id');
    }



}
