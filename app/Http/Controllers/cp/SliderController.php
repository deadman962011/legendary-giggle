<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SliderController extends Controller
{

    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:home_slide_add_slide','permission:home_slide_delete_slide'])->only(['Get','Update']);
    
    }


    //
    public function List() {
        // no action
    }

    public function Create() {
        //no action    
    }

    
    public function Store(Request $request) {
        //no action
    }

    
    public function Get(Request $request) {
        
        //get slider 
        $slider=Slider::where('name',$request->name)->firstOrFail();

        return view('slider.show',compact('slider'));
        
    
    }


    public function Update(Request $request) {
        try {
            // Start a database transaction
            DB::beginTransaction();

            $slider=Slider::where('name',$request->name)->firstOrFail();
            $slider->slides()->delete();
            $uploadIds = $request->input('slider_images');
            foreach ($uploadIds as $uploadId) {
                Slide::create([
                    'slider_id' => $slider->id,
                    'upload_id' => $uploadId,
                    'status'=>true
                ]);
            }
    
            // Commit the transaction
            DB::commit();
            return response()->json([
                'success' => true,
                'payload' => null, 
                'message' => 'Hone Slider successfully saved'
            ], 200);
        }
        catch(\Throwable $th){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing Went Wrong'
            ], 200);
        }
    }

    
    public function updateStatus(Request $request) {
        
    }

    // public function addSlide(Request $request)  {
        
    // }

    // public function removeSlide(Request $request)  {
        
    // }

    // public function updateSlideStatus()  {
        
    // }




}
