<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ApiFileController extends Controller
{
    //


    function Upload(Request $request) {
        
        try {
            
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

            $upload->file_original_name=$newPath;
            $upload->extension = $extension;
            $upload->file_name = $newPath;
            $upload->type = $type[$upload->extension];
            $upload->file_size = $size;
            $upload->save();

            return response()->json([
                'success' => true,
                'message' => __("Image updated"),
                'payload'=>[
                    'id'=>$upload->id,
                    'path' => getFileUrl($upload->id)
                ]
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
