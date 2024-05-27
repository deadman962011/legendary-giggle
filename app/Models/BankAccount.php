<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable=['bank_name','full_name','iban','account_number','user_id','status','isDeleted'];
     

    public function scopeActive(Builder $query): void
    { 
        $query->where('isDeleted', false)->where('status', true);
    }



}
