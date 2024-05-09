<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Http\Requests\cp\category\saveCategoryRequest;
use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:edit_category','permission:delete_category'])->only('List');
        $this->middleware(['permission:add_category'])->only(['Create','Store']);
        $this->middleware(['permission:edit_category'])->only(['Edit','Update']);
        $this->middleware(['permission:delete_category'])->only('Delete');
    }

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
            
            $maxOrderLevel = Category::max('order_level') ?? 0;
            //save category item
            $saveCategory = new Category();
            $saveCategory->name=$request->{'name_'.$request->lang[0]};
            $saveCategory->order_level=$maxOrderLevel+1;
            $saveCategory->cover_image=$request->cover_image;
            $saveCategory->banner=$request->banner;
            $saveCategory->save();
            
            for ($i=0; $i < count($request->lang); $i++) { 
                //save category translations
                CategoryTranslation::create([
                    'key'=>'name',
                    'value'=>$request->{'name_'.$request->lang[$i]},
                    'lang' =>$request->lang[$i], 
                    'category_id' => $saveCategory->id
                ]);
            }



            return response()->json([
                'success'=>true,
                'message'=>'category successfully saved',
                'action'=>'redirect_to_url',
                'action_val'=>route('category.list')
            ]);
            
        } catch (\Throwable $th) {
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


    function UpdateStatus(Request $request)  {
        
        $updateCategory=Category::findOrFail($request->id);
        $updateCategory->update([
            'status'=>!$updateCategory->status
        ]);
        
        return response()->json([
            'success'=>true,
            'message'=>__('category_status_successfully_updated')
        ],200);

    }



    public function Delete(Request $request){

        $deleteCategory=Category::findOrFail($request->id);

        //update category
        $deleteCategory->update([
            'isDeleted'=>true
        ]);

        return response()->json([
            'success'=>true,
            'action'=>'redirect_to_url',
            'action_val'=>route('category.list'),
            'message'=>__('category_successfully_deleted')
        ],200);


    }




}
