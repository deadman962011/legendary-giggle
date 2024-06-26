<?php

namespace App\Http\Controllers\api\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\shop\updateShopContactRequest;
use App\Http\Resources\merchant\MerchantResource;
use App\Models\Language;
use App\Models\Shop;
use App\Models\ShopTranslation;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
                'shop_contact_phone'=>$request->phone,
                'shop_contact_website'=>$request->website
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
        
                try {
            $shop = Shop::find(auth()->user()->id);
            $type = array(
                "jpg" => "image",
                "jpeg" => "image",
                "png" => "image",
                "svg" => "image",
                "webp" => "image",
                "gif" => "image",
            );
            $image = $request->image;
            $request->filename;
            $realImage = base64_decode($image);
            $dir = public_path('uploads/all');
            $full_path = "$dir/$request->filename";

            $file_put = file_put_contents($full_path, $realImage); // int or false

            if ($file_put == false) {
                return response()->json([
                    'result' => false,
                    'message' => "File uploading error",
                    'path' => ""
                ]);
            }

            $upload = new Upload;
            $extension = strtolower(File::extension($full_path));
            $size = File::size($full_path);

            if (!isset($type[$extension])) {
                unlink($full_path);
                return response()->json([
                    'sucess' => false,
                    'message' => "Only image can be uploaded",
                    'path' => ""
                ]);
            }



            $upload->file_original_name = null;
            $arr = explode('.', File::name($full_path));
            for ($i = 0; $i < count($arr) - 1; $i++) {
                if ($i == 0) {
                    $upload->file_original_name .= $arr[$i];
                } else {
                    $upload->file_original_name .= "." . $arr[$i];
                }
            }

            //unlink and upload again with new name
            unlink($full_path);
            $newFileName = rand(10000000000, 9999999999) . date("YmdHis") . "." . $extension;
            $newFullPath = "$dir/$newFileName";

            $file_put = file_put_contents($newFullPath, $realImage);

            if ($file_put == false) {
                return response()->json([
                    'success' => false,
                    'message' => "Uploading error",
                    'path' => ""
                ]);
            }

            $newPath = "uploads/all/$newFileName";

            $upload->file_original_name = $newPath;
            $upload->extension = $extension;
            $upload->file_name = $newPath;
            $upload->type = $type[$upload->extension];
            $upload->file_size = $size;
            $upload->save();

            $shop->menu = $upload->id;
            $shop->save();


            return response()->json([
                'success' => true,
                'message' => trans("custom.menu_updated"),
                'path' => getFileUrl($upload->id)
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'result' => false,
                'message' => $th->getMessage(),
                'path' => ""
            ]);
        }




    }

    public  function UpdateLogo(Request $request) {
        
        try {
    $shop = Shop::find(auth()->user()->id);
    $type = array(
        "jpg" => "image",
        "jpeg" => "image",
        "png" => "image",
        "svg" => "image",
        "webp" => "image",
        "gif" => "image",
    );
    $image = $request->image;
    $request->filename;
    $realImage = base64_decode($image);
    $dir = public_path('uploads/all');
    $full_path = "$dir/$request->filename";

    $file_put = file_put_contents($full_path, $realImage); // int or false

    if ($file_put == false) {
        return response()->json([
            'result' => false,
            'message' => "File uploading error",
            'path' => ""
        ]);
    }

    $upload = new Upload;
    $extension = strtolower(File::extension($full_path));
    $size = File::size($full_path);

    if (!isset($type[$extension])) {
        unlink($full_path);
        return response()->json([
            'sucess' => false,
            'message' => "Only image can be uploaded",
            'path' => ""
        ]);
    }



    $upload->file_original_name = null;
    $arr = explode('.', File::name($full_path));
    for ($i = 0; $i < count($arr) - 1; $i++) {
        if ($i == 0) {
            $upload->file_original_name .= $arr[$i];
        } else {
            $upload->file_original_name .= "." . $arr[$i];
        }
    }

    //unlink and upload again with new name
    unlink($full_path);
    $newFileName = rand(10000000000, 9999999999) . date("YmdHis") . "." . $extension;
    $newFullPath = "$dir/$newFileName";

    $file_put = file_put_contents($newFullPath, $realImage);

    if ($file_put == false) {
        return response()->json([
            'success' => false,
            'message' => "Uploading error",
            'path' => ""
        ]);
    }

    $newPath = "uploads/all/$newFileName";

    $upload->file_original_name = $newPath;
    $upload->extension = $extension;
    $upload->file_name = $newPath;
    $upload->type = $type[$upload->extension];
    $upload->file_size = $size;
    $upload->save();

    $shop->shop_logo = $upload->id;
    $shop->save();


    return response()->json([
        'success' => true,
        'message' => trans("custom.menu_updated"),
        'path' => getFileUrl($upload->id)
    ]);
} catch (\Throwable $th) {

    return response()->json([
        'result' => false,
        'message' => $th->getMessage(),
        'path' => ""
    ]);
}




}

}
