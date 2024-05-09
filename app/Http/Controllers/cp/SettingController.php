<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    //

    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:edit_general_settings'])->only('List');
    }



    public function List(Request $request)
    {

        //
        $section = $request->section;

        $settings = Setting::where('section', $section)->get();
        if ($settings->count() === 0) {
            abort(404);
        }

        return view('setting.list', ['settings' => $settings]);
    }



    public function Update(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'key' => 'required',
                'value' => 'required',
            ]);

            if ($validator->fails()) {
                throw 'validation error ';
            }

            DB::beginTransaction();
            //
            $setting = Setting::where('key', $request->key)->firstOrFail();

            $setting->update([
                'value' => $request->value
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'setting successfully saved',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Somthing Went Wrong',
                'debug' => $th->getMessage()
            ]);
        }
    }
}
