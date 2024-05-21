<?php

namespace App\Http\Controllers\api\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\shop\availability\addSlotRequest;
use App\Http\Requests\api\shop\availability\removeSlotRequest;
use App\Http\Requests\api\shop\availability\updateSlotRequest;
use App\Models\ShopAvailabiltiy;
use App\Models\ShopAvailabiltiySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopAvailabilityController extends Controller
{
    //
    public function GetDays(Request $request)
    {

        $shop = Auth::guard('shop')->user();
        try {
            $shop_availability = ShopAvailabiltiy::where('shop_id', $shop->id)->get();
            return response()->json([
                'success' => true,
                'payload' => $shop_availability,
                'message' => 'shop availability successfully loaded'
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'unale to load shop availability',
                'debug'=>$th->getMessage()
            ], 500);
        }
    }

    public function ToggleDay(Request $request)
    {
        try {
            DB::beginTransaction();
            $shop = Auth::guard('shop')->user();
            $shop_availability = ShopAvailabiltiy::where('id',$request->shop_availability_id)->where('shop_id',$shop->id)->firstOrFail();
            $shop_availability->update([
                'status' => !$shop_availability->status
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'payload' => null,
                'message' => 'day status successfully updated'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing went wrong',
                'debug' => $th->getMessage()
            ], 500);
        }
    }

    public function AddSlot(addSlotRequest $request)
    {
        //
        try {

            DB::beginTransaction();
            $shop = Auth::guard('shop')->user();

            $shop_availability = ShopAvailabiltiy::findOrFail($request->shop_availability_id);

            ShopAvailabiltiySlot::create([
                'start' => $request->start,
                'end' => $request->end,
                'shop_id' => $shop->id,
                'shop_availability_id' => $shop_availability->id
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'payload' => null,
                'message' => 'slot successfully added'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing went wrong',
                'debug' => $th->getMessage()
            ], 500);
        }
    }


    public function RemoveSlot(removeSlotRequest $request)
    {
        try {

            $shop=Auth::guard('shop')->user();
            DB::beginTransaction();
            $slot = ShopAvailabiltiySlot::where('id',$request->id)->whereHas('shopAvailability',function($query) use($shop) {
                return $query->where('shop_id',$shop->id);
            })->firstOrFail();
            $slot->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'payload' => null,
                'message' => 'slot successfully removed'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing went wrong'
            ], 500);
        }
    }



    public function UpdateSlot(updateSlotRequest $request)  {

        try {

            $shop=Auth::guard('shop')->user();
            DB::beginTransaction();
            $slot = ShopAvailabiltiySlot::where('id',$request->id)->whereHas('shopAvailability',function($query) use($shop) {
                return $query->where('shop_id',$shop->id);
            })->firstOrFail();
            $slot->update([
                'start'=>$request->start !=='null' ? $request->start : null,
                'end'=>$request->end !=='null' ?  $request->end : null
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'payload' => null,
                'message' => 'slot successfully updated'
            ], 200);
        } catch (\Throwable $th) {
        DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing went wrong'
            ], 500);
        }



    }

}
