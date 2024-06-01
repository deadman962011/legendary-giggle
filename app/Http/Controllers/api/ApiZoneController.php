<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\ZoneResource;
use App\Models\District;
use App\Models\Zone;
use Illuminate\Http\Request;

class ApiZoneController extends Controller
{
    //


    public function Get(Request $request)
    {
        try {
            $zones = Zone::active()->selectRaw("*,ST_AsText(ST_Centroid(`coordinates`)) as center")->get();
            return response()->json([
                'success' => true,
                'payload' => ZoneResource::collection($zones) , //
                'message' => 'Zones successfully Loaded'
            ], 200);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing Went Wrong'
            ], 200);
        }

    }


    public function GetDistricts(Request $request)  {
        
        try {
            $districts = District::where('zone_id',$request->id)->get();

            return response()->json([
                'success' => true,
                'payload' => DistrictResource::collection($districts),
                'message' => 'Zone Districts successfully Loaded'
            ], 200);
        } catch (\Throwable $th) { 
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing Went Wrong',
                'debug'=>$th->getMessage()
            ], 200);
        }



    }

}
