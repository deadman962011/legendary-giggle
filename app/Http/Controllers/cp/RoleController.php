<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    //

    public function List(Request $request)
    {

        $roles=Role::where('shop_id',0)->get();

        return view('role.list',compact('roles'));
    }


    public function Create()
    {
        //
        $permissions = Permission::where('guard_name','web')->get();
        return view('role.new', compact('permissions'));
    }


    public function store(Request $request)
    {

        try {

            DB::beginTransaction();

            $role = Role::create(['name' => $request->name_en]);
            $role->givePermissionTo($request->permissions);

            $role_translation = RoleTranslation::firstOrNew(['lang' => 'en', 'role_id' => $role->id]);
            $role_translation->name = $request->name_en;
            $role_translation->save();

            $role_translation_ar = RoleTranslation::firstOrNew(['lang' => 'sa', 'role_id' => $role->id]);
            $role_translation_ar->name = $request->name_ar;
            $role_translation_ar->save();

            DB::commit();
            $response_data['success']    =   true;
            $response_data['message']   =  trans('New Role has been added successfully');
            $response_data['action'] = 'redirect_to_url';
            $response_data['action_val']  =   route('role.list');
            return response()->json($response_data);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing Went Wrong'
            ], 200);

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit(Request $request, $id)
    // {
    //     $lang = $request->lang;
    //     $role = Role::findOrFail($id);
    //     return view('backend.staff.staff_roles.edit', compact('role', 'lang'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $role = Role::findOrFail($id);
    //     if ($request->lang == env("DEFAULT_LANGUAGE")) {
    //         $role->name = $request->name_en;
    //     }
    //     $role->syncPermissions($request->permissions);
    //     $role->save();

    //     // Role Translation
    //     $role_translation = RoleTranslation::firstOrNew(['lang' => 'en', 'role_id' => $role->id]);
    //     $role_translation->name = $request->name_en;
    //     $role_translation->save();

    //     $role_translation_ar = RoleTranslation::firstOrNew(['lang' => 'sa', 'role_id' => $role->id]);
    //     $role_translation_ar->name = $request->name_ar;
    //     $role_translation_ar->save();

    //     $response_data['status']    =   true;
    //     $response_data['message']   =  trans('Role has been updated successfully');
    //     // $response_data['redirect']  =   route('roles.index');
    //     return response()->json($response_data);

    //     // return redirect()->route('roles.index');
    // }
}
