<?php

namespace App\Http\Controllers\api;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class ApiCategoryController extends Controller
{
    //
    public function Get() {
        $categories = Category::where('isDeleted',false)->orderBy('order_level')->get();

        return response()->json(
            CategoryResource::collection($categories),
            
        //     [
        //     'success'=>true,
        //     'payload'=>
        //     'message'=>'Categories Successfully Loaded'
        // ]
    );
    }
}
