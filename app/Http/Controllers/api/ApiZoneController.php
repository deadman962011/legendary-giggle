<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ZoneResource;
use App\Models\Zone;
use Illuminate\Http\Request;

class ApiZoneController extends Controller
{
    //


    public function Get(Request $request)
    {

        //get zones




        try {
            $zones = Zone::active()->get();

            return response()->json([
                'success' => true,
                'payload' => ZoneResource::collection($zones),
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
}
