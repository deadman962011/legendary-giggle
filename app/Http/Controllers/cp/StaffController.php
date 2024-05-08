<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Http\Requests\cp\staff\saveStaffRequest;
use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StaffController extends Controller
{
    //
    public function List(Request $request)
    {

        $staff=Admin::all();

        return view('staff.list',compact('staff'));
    }


    public function Create()
    {
        // except
        $roles = Role::where('name','!=','Shop Admin')->where('shop_id',0)->get();
        return view('staff.new', compact('roles'));
    }


    public function store(saveStaffRequest $request)
    {

        try {

            DB::beginTransaction();

            $admin=Admin::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password)
            ]);

            $role = Role::where('id' , $request->role_id)->firstOrFail();
            $admin->assignRole($role);

            DB::commit();
            $response_data['success']    =   true;
            $response_data['message']   =  trans('New Staff has been added successfully');
            $response_data['action'] = 'redirect_to_url';
            $response_data['action_val']  =   route('staff.list');
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
