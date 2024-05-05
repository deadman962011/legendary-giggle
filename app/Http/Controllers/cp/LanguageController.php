<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    //

    public function change(Request $request) 
     {
    
        try {
            $lang=\App\Models\Language::where('key',$request->locale)->firstOrFail();
    
            session()->put('locale', $request->locale);
            app()->setLocale($request->locale);
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Language Successfully updated'
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
