<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopPayCommissionRequest extends Model
{
    use HasFactory;

    // offer_id amount	sender_full_name amount	sender_phone	notice	reason	state	created_at	updated_at
protected $fillable=['offer_id','amount','sender_full_name','sender_phone','deposit_at','notice','reason','state','deposit_bank_account_id'];


    /**
     * Get the Offer associated with the ShopPayCommissionRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Offer() 
    {
        return $this->hasOne(Offer::class, 'id', 'offer_id');
    }

    /**
     * Get all of the attachments for the ShopPayCommissionRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachments()
    {
        return $this->hasMany(ShopPayCommissionRequestAttachment::class, 'request_id', 'id');
    }



}
