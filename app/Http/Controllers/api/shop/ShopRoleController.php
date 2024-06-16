<?php

namespace App\Http\Controllers\api\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\shop\role\saveShopRoleRequest;
use App\Http\Resources\merchant\MerchantRoleResource;
use App\Models\Language;
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



    public function Get(Request $request) {
        
        $shop=Auth::guard('shop')->user();
 
        $roles = Role::where('shop_id', $shop->id)->paginate(6);

        return response()->json([
            'success' => true,
            'payload' => MerchantRoleResource::collection($roles)->resource,
            'message' => 'role Successfully Loaded'
        ], 200);

    }


    public function Store(saveShopRoleRequest $request)  {
        
        
        $shop=Auth::guard('shop')->user();
        try {

            //
            $permissions=explode(',',$request->permissions);
            
            DB::beginTransaction();

            $role = Role::create([
                'name' => $request->name_en,
                'guard_name'=>'shop',
                'shop_id'=>$shop->id
            ]);
            $role->givePermissionTo($permissions);
            
            //
            $languages=Language::where('status',true)->get();

            for ($i=0; $i < count($languages); $i++) { 
                if(array_key_exists("name_".$languages[$i]->lang,$request->all())){
                    RoleTranslation::create([
                        'key'=>'name',
                        'lang'=>$languages[$i], //default language
                        'value'=> $request->{"name_".$languages[$i]->lang},
                        'role_id'=>$role->id
                    ]);
                }
            }
 
            DB::commit();
            $response_data['success']    =   true;
            $response_data['message']   =  trans('New Role has been added successfully');
            return response()->json($response_data);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing Went Wrong'
            ], 200);
        }

    }

}
