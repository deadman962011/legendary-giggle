<?php

namespace App\Http\Controllers\api\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\shop\updateShopContactRequest;
use App\Http\Resources\merchant\MerchantResource;
use App\Models\Language;
use App\Models\Shop;
use App\Models\ShopTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    //

    public function Get(Request $request)
    {
        $shop=Auth::guard('shop')->user();

        try {

            $getShop=Shop::findOrFail($shop->id);
            return response()->json([
                'success' => true,
                'payload' =>  new MerchantResource($getShop),
                'message' => 'Shop Successfully loaded'
            ], 200);
        }
        catch(\Throwable $th){
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing went wrong'
            ], 500);
        }
    }

    public function Update(Request $request)  {
        //
        $shop=Auth::guard('shop')->user();


        try {
            DB::beginTransaction();
            $getShop=Shop::findOrFail($shop->id);

            //update            
            $lang_keys=Language::pluck('key');
            
            $getShop->update([
                'name'=>$request->shop_name_en
            ]);

            for ($i = 0; $i < count($lang_keys); $i++) {
                ShopTranslation::where('key','name')->where('lang',$lang_keys[$i])->where('shop_id',$shop->id)->
                updateOrCreate([
                    'key'=>'name',
                    'lang'=>$lang_keys[$i],
                    'shop_id'=>$shop->id
                ],[
                    'key'=>'name',
                    'value'=>$request->{"shop_name_" . $lang_keys[$i]},
                    'lang'=>$lang_keys[$i],
                    'shop_id'=>$shop->id,
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'payload' => null,
                'message' => 'Shop Contact information Successfully updated'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing went wrong',
                'debug'=>$th->getMessage()
            ], 500);
        }

        


    }

    public function UpdateContact(updateShopContactRequest $request) {
        
        //
        $shop=Auth::guard('shop')->user();

        try {

            DB::beginTransaction();

            $updateShop=Shop::findOrFail($shop->id);

            $updateShop->update([
                'shop_contact_email'=>$request->email,
                'shop_contact_phone'=>$request->phone
            ]);


            DB::commit();
            return response()->json([
                'success' => true,
                'payload' => null,
                'message' => 'Shop Contaact information Successfully updated'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing went wrong',
                'debug'=>$th->getMessage()
            ], 500);
        }
    }


    public  function UpdateMenu(Request $request) {
        

        



    }

}
