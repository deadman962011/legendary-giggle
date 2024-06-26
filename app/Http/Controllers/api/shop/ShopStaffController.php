<?php

namespace App\Http\Controllers\api\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\shop\staff\saveShopStaffRequest;
use App\Http\Requests\api\shop\staff\updateShopStaffRequest;
use App\Http\Resources\merchant\MerchantStaffDetailsResource;
use App\Http\Resources\merchant\MerchantStaffResource;
use App\Mail\ShopStaffAdded;
use App\Models\Role;
use App\Models\ShopAdmin;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ShopStaffController extends Controller
{
    //

    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:display_staff',])->only('List');
        $this->middleware(['permission:add_shop_staff'])->only('Create');
        $this->middleware(['permission:edit_shop_staff'])->only('Edit');
        $this->middleware(['permission:delete_shop_staff'])->only('Delet');
    }


    public function Get(Request $request)
    {

        $shop=Auth::guard('shop')->user()->shop;

        $staff=ShopAdmin::where('shop_id',$shop->id)->where('isDeleted',false)->paginate(20);
   
        return response()->json([
            'success' => true,
            'payload' => MerchantStaffResource::collection($staff)->resource,
            'message' => 'Staff Successfully Loaded'
        ], 200);
    }


    public function GetStaff(Request $request)
    {

        $shop = Auth::guard('shop')->user();

        try {
            $staff = ShopAdmin::where('id', $request->id)->where('shop_id', $shop->id)->where('isDeleted', false)->firstOrFail();
    
            return response()->json([
                'success' => true,
                'payload' => new MerchantStaffDetailsResource($staff),
                'message' => 'staff details Successfully Loaded'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'somthing went wrong'
            ], 500);
        }

    }



    public function Store(saveShopStaffRequest $request) {

        //
        $shop=Auth::guard('shop')->user()->shop;

        try {
            
            DB::beginTransaction();

            $admin=ShopAdmin::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'password'=>bcrypt(generate_random_token(12)),
                'shop_id'=>$shop->id,
                'auth_token'=>generate_random_token(6)
            ]);

            $role = Role::where('id' , $request->role_id)->firstOrFail();
            $admin->assignRole($role);

            DB::commit();

            Mail::to($request->email)->send(new ShopStaffAdded());

            return response()->json([
                'success' => true,
                'payload' => null,
                'message' => 'shop staff successfully saved'
            ], 201);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing Went Wrong',
                'debug'=>$th->getMessage()
            ], 500);
        }
    }



    public function Update(updateShopStaffRequest $request)
    {


        $shop = Auth::guard('shop')->user();
        try {
 
            DB::beginTransaction();

            //
            $staff = ShopAdmin::where('id', $request->id)->where('shop_id',$shop->id)->firstOrFail();
            $staff->update([
                'name'=>$request->name,
                'phone'=>$request->phone
            ]);

            if($request->role_id !== $staff->roles[0]->id){
                $staff->roles->map(function($role) use($staff) {
                    $staff->removeRole($role);
                });
                $newRole=Role::where('id',$request->role_id)->where('shop_id',$shop->id)->firstOrFail();
                $staff->assignRole($newRole);
            }

            DB::commit();
            $response_data['success']    =   true;
            $response_data['message']   =  trans('staff has been updated successfully');
            return response()->json($response_data, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing Went Wrong',
                'debug' => $th->getMessage()
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
