<?php

namespace App\Http\Controllers\api\shop;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\ShopAdmin;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopStaffController extends Controller
{
    //

    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:display_staff',])->only('List');
        $this->middleware(['permission:add_staff'])->only('Create');
        $this->middleware(['permission:edit_staff'])->only('Edit');
        $this->middleware(['permission:delete_staff'])->only('Delet');
    }


    public function List(Request $request)
    {

        $shop=Auth::guard('shop')->user()->shop;

        $staff=ShopAdmin::where('shop_id',$shop->id);
   
        return response()->json([
            'success' => true,
            'payload' =>$staff,
            'message' => 'Staff Successfully Loaded'
        ], 200);
    }

    public function Create(Request $request) {

        try {
            
            DB::beginTransaction();

            $admin=ShopAdmin::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt(generate_random_token(12))
            ]);

            $role = Role::where('id' , $request->role_id)->firstOrFail();
            $admin->assignRole($role);

            DB::commit();


            
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing Went Wrong'
            ], 500);
        }
    }


    public function Delete(Request $request)  {

        //
        $shopAdmin=ShopAdmin::where('staff_id',$request->staff_id)->first();

        $shopAdmin->update([
            'isDeleted'=>true,
            'status'=>true
        ]);

        //remove roles for the shop admin 
        foreach ($shopAdmin->roles as $role) {
            $shopAdmin->removeRole($role->name);
        }



    }

}
