<?php

namespace App\Http\Controllers\api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class ApiCategoryController extends Controller
{
    //
    public function Get()
    {
        $categories = Category::active()->where('isDeleted', false)->orderBy('order_level')->get();

        return response()->json(
            [
                'success' => true,
                'payload' => CategoryResource::collection($categories),
                'message' => 'Categories Successfully Loaded'
            ]
        );
    }
}


