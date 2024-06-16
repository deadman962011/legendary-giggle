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
        'auth_token',
        'shop_id'
    ];
    
    protected $hidden=['auth_token','password'];


    /**
     * Get the shop associated with the ShopAdmin
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shop() 
    {
        return $this->hasOne(Shop::class, 'id', 'shop_id');
    }


    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


}
