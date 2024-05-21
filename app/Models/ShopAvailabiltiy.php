<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopAvailabiltiy extends Model
{
    use HasFactory;

    protected $fillable=['day','status','shop_id'];

    protected $with=['slots'];

    /**
     * Get all of the slots for the ShopAvailabiltiy
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function slots()
    {
        return $this->hasMany(ShopAvailabiltiySlot::class, 'shop_availability_id', 'id');
    }




}
