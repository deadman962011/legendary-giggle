<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'gender',
        'birth_date',
        'auth_token',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'auth_token'
    ];

    protected $appends=['avatar_image'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    /**
     * Get the wallet a the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wallet()
    {
        return $this->hasOne(UserWallet::class, 'user_id', 'id');
    }



    public function getAvatarImageAttribute() {
        return getFileUrl($this->avatar);

    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    function getZoneAttribute()  {
        
        $request = request();
        $lat = $request->header('latitude');
        $lon = $request->header('longitude');
        $zone=Zone::whereContains('coordinates', new Point($lat, $lon, 4326))->first(); // For MariaDB use 4326 0 for mysql
        return $zone->id ?? null;

    }


}
