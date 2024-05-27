<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CouponDetailsResource;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use Illuminate\Container\RewindableGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiCouponController extends Controller
{
    //
    public function Get(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'category' => 'sometimes|in:onsite,online,',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validation_error',
            ], 422);
        }


        $coupons = Coupon::active()->when($request->category, function ($query) use ($request) {
            return $query->where('category', $request->category);
        })->paginate(6);

        return response()->json(
            [
                'success' => true,
                'payload' => CouponResource::collection($coupons)->resource,
                'message' => 'Coupons Successfully Loaded'
            ]
        );
    }


    public function GetCouponDetails(Request $request)
    {



        try {
            $coupon = Coupon::active()->where('id', $request->id)->firstOrFail();
            return response()->json(
                [
                    'success' => true,
                    'payload' => new CouponDetailsResource($coupon),
                    'message' => 'Coupons Successfully Loaded'
                ]
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'success' => false,
                    'payload' => null,
                    'message' => 'Somthing went wrong',
                    'debug'=>$th->getMessage()
                ]
            );
        }
    }
}
