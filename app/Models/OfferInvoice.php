<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferInvoice extends Model
{
    use HasFactory;


    // amount	
    protected $fillable=['amount','vat','payload','commission_amout','user_id','offer_id','isCanceled'];







}
