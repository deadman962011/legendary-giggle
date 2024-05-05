<?php

namespace App\Http\Middleware\Api;

use App;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class ValidateUserLocation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 'api.home.layout'
        $coordinates=[
            'latitude'=>$request->header('latitude'),
            'longitude'=>$request->header('longitude'),
        ];
        $validator = Validator::make($coordinates,[
        'latitude'=>'required|numeric|gt:0',
        'longitude'=>'required|numeric|gt:0',
        ]);

        if ($validator->fails() ) {
            return response()->json([
                'success'=>false,
                'message'=>'user location coordinates not valid',
            ]);
        }
        
        return $next($request);
    }





    public function getDistance($latitude1, $longitude1, $latitude2, $longitude2) {
        $earth_radius = 6371;
    
        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);
    
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) *
             sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;
    
        return $d; // returns the distance in kilometer
    }


}
