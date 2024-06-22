<?php

namespace App\Http\Controllers\api\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\shop\role\saveShopRoleRequest;
use App\Http\Requests\api\shop\role\updateShopRoleRequest;
use App\Http\Requests\PermissionResource;
use App\Http\Resources\merchant\MerchantRoleResource;
use App\Http\Resources\merchant\MerchantPermissionResource;
use App\Http\Resources\merchant\MerchantRoleDetailsResource;
use App\Models\Language;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\RoleTranslation;
use Illuminate\Support\Facades\Auth;

class ShopRoleController extends Controller
{
    //
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:display_role',])->only('List');
        $this->middleware(['permission:add_shop_role'])->only('Create');
        $this->middleware(['permission:edit_shop_role'])->only('Edit');
        $this->middleware(['permission:delete_shop_role'])->only('Delete');
    }



    public function Get(Request $request)
    {

        $shop = Auth::guard('shop')->user();

        $roles = Role::where('shop_id', $shop->id)->where('isDeleted', false)->paginate(20);

        return response()->json([
            'success' => true,
            'payload' => MerchantRoleResource::collection($roles)->resource,
            'message' => 'role Successfully Loaded'
        ], 200);
    }


    public function GetRole(Request $request)
    {

        $shop = Auth::guard('shop')->user();

        $role = Role::where('id', $request->id)->where('shop_id', $shop->id)->where('isDeleted', false)->firstOrFail();

        return response()->json([
            'success' => true,
            'payload' => new MerchantRoleDetailsResource($role),
            'message' => 'role details Successfully Loaded'
        ], 200);
    }



    public function GetAll(Request $request)
    {

        $shop = Auth::guard('shop')->user();

        $roles = Role::where('shop_id', $shop->id)->where('isDeleted', false)->get();

        return response()->json([
            'success' => true,
            'payload' => MerchantRoleResource::collection($roles),
            'message' => 'all role Successfully Loaded'
        ], 200);
    }



    public function Store(saveShopRoleRequest $request)
    {

        $shop = Auth::guard('shop')->user();
        try {

            //
            $permissions = explode(',', $request->permissions);

            DB::beginTransaction();

            $role = Role::create([
                'name' => $request->name_en,
                'guard_name' => 'shop',
                'shop_id' => $shop->id
            ]);
            $role->givePermissionTo($permissions);

            //
            $languages = Language::where('status', true)->get();

            for ($i = 0; $i < count($languages); $i++) {
                if (array_key_exists("name_" . $languages[$i]->key, $request->all())) {
                    RoleTranslation::create([
                        'key' => 'name',
                        'lang' => $languages[$i]->key, //default language
                        'value' => $request->{"name_" . $languages[$i]->key},
                        'role_id' => $role->id
                    ]);
                }
            }

            DB::commit();
            $response_data['success']    =   true;
            $response_data['message']   =  trans('New Role has been added successfully');
            return response()->json($response_data, 201);
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



    public function Update(updateShopRoleRequest $request)
    {


        $shop = Auth::guard('shop')->user();
        try {

            //
            $permissions = explode(',', $request->permissions);

            DB::beginTransaction();

            //
            $role = Role::where('id', $request->id)->firstOrFail();
            $role->syncPermissions($permissions);

            $languages = Language::where('status', true)->get();
            for ($i = 0; $i < count($languages); $i++) {
                if (array_key_exists("role_name_in_" . $languages[$i]->key, $request->all())) {
                     RoleTranslation::where('key', 'name')->where('lang', $languages[$i]->key)->where('role_id', $request->id)->update([
                        'value' => $request->{"role_name_in_" . $languages[$i]->key}
                    ]);
                }
            }

            DB::commit();
            $response_data['success']    =   true;
            $response_data['message']   =  trans('role has been updated successfully');
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




    public function GetPermissions()
    {
        //
        $permissions = Permission::where('guard_name', 'shop')->get();

        return  response()->json([
            'success' => true,
            'payload' => MerchantPermissionResource::collection($permissions),
            'message' => 'permissions successfully loaded'
        ], 200);
    }
}
