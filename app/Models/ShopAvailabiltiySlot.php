<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class ShopAvailabiltiySlot extends Model
{
    use HasFactory;
    
    protected $fillable=['start','end','shop_availability_id'];

    protected $appends=['start_formatted','end_formatted'];


    public function getStartFormattedAttribute()
    {   
        return  $this->start !== null ? Carbon::parse($this->start)->format('H:m') : null;
    }

    // // Accessor for end column
    public function getEndFormattedAttribute($value)
    {
        return $this->end !==null ? Carbon::parse($this->end)->format('H:m') : null;
    }

    /**
     * Get the shopAvailability associated with the ShopAvailabiltiySlot
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shopAvailability()
    {
        return $this->hasOne(ShopAvailabiltiy::class, 'id', 'shop_availability_id');
    }


}
