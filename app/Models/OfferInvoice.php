<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferInvoice extends Model
{
    use HasFactory;


    // amount	
    protected $fillable=['amount','vat','payload','commission_amout','user_id','offer_id','isCanceled'];

    protected $appends=['points','state'];


    /**
     * Get the offer associated with the OfferInvoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function offer()
    {
        return $this->hasOne(Offer::class, 'id', 'offer_id');
    }

    public function getPointsAttribute() {
        $amount=$this->amount;
        $offer_cashback_amount=intval($this->offer->cashback_amount);
        return  $amount * ($offer_cashback_amount / 100);
    }

    public function getStateAttribute()   {
 
        $this->offer->state;
        if($this->offer->state==='active'){
            return 'pending';
        }
        if($this->offer->state==='expired' && $this->isCanceled){
            return 'canceled';
        }
        if($this->offer->state==='expired' && !$this->isCanceled && $this->offer->isPaid){
            return 'paid';
        }
        else{
            return 'unknown';
        }
    }






}
