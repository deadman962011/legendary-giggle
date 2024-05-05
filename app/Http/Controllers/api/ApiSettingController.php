<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ApiSettingController extends Controller
{
    //



    function Get(Request $request) {
        


    }



    function GetByKey(Request $request) {
        
        try {
            
            $setting=Setting::where('key',$request->key)->firstOrFail();
            
            return response()->json(
                [
                    'success' => true,
                    'payload' => $setting->value,
                    'message' => 'Setting Successfully Loaded'
                ]
            );
            


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing Went Wrong'
            ], 200);
        }
    }











}
