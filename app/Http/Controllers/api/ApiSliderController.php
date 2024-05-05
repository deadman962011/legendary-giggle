<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SliderResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Slider;


class ApiSliderController extends Controller
{



    public function Get(Request $request)
    {
        try { 
            $slider = Slider::where('name', $request->name)->firstOrFail();

            return response()->json([
                'success' => true,
                'payload' => new SliderResource($slider) ,
                'message' => 'Slider successfully Loaded'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing Went Wrong'
            ], 200);
        }
    }
}
