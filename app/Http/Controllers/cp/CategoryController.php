<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Http\Requests\cp\category\saveCategoryRequest;
use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function List(){

        //get categories
        $categories = Category::where('isDeleted',false)->get();
        return view('category.list',['categories'=>$categories]);

    }

    public function Create(){
        
        //get parent categories
        $parentCategories=Category::where('isDeleted',false)->where('parent_id',null)->get();
        return view('category.new',['parentCategories'=>$parentCategories]);

    }
    
    public function Store(saveCategoryRequest $request){


        try {

            $maxOrderLevel = Category::max('order_level');

            //save category item
            $saveCategory = new Category();
            $saveCategory->name=$request->name;
            $saveCategory->order_level=$maxOrderLevel+1;
            $saveCategory->cover_image=$request->cover_image;
            $saveCategory->banner=$request->banner;
            $saveCategory->save();
            
            //save category translations
            CategoryTranslation::create([
                'key'=>'name',
                'value'=>$request->name,
                'lang' => 'en', //default language
                'category_id' => $saveCategory->id
            ]);

            return response()->json([
                'success'=>true,
                'message'=>'category successfully saved',
                'action'=>'redirect_to_url',
                'action_val'=>route('category.list')
            ]);
            
        } catch (\Throwable $th) {
            dd($th);
            return response()->json([
                'success'=>false,
                'message'=>'Somthing Went Wrong'
            ]);
            //throw $th;
        }






    }

    public function Edit(){

    }

    public function Update(Request $request){

    }

    public function Delete(Request $request){

    }




}
