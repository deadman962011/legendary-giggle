<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ShopAdmin extends Authenticatable implements JWTSubject
{
    use HasFactory,HasRoles;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'shop_id'
    ];


    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


}
