<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Http\Requests\cp\coupon\saveCouponRequest;
use App\Models\Coupon;
use App\Models\CouponTranslation;
use App\Models\CouponVariation;
use App\Models\CouponVariationLic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{


    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:edit_coupon', 'permission:delete_coupon'])->only('List');
        $this->middleware(['permission:add_coupon'])->only(['Create', 'Store']);
        $this->middleware(['permission:edit_coupon'])->only(['Edit', 'Update']);
        $this->middleware(['permission:delete_coupon'])->only('Delete');
    }

    function List(Request $request)
    {


        $coupons = Coupon::where('isDeleted', false)->get();

        return view('coupons.list', compact('coupons'));
    }


    function Create(Request $request)
    {
        return view('coupons.new');
    }

    function Store(saveCouponRequest $request)
    {

        //
        DB::beginTransaction();

        try {

            //save  
            $coupon = Coupon::create([
                'name' => $request->{'name_' . $request->lang[0]},
                'validity' => 'test',
                'thumbnail' => $request->image,
                'category' => $request->category,
            ]);

            if (isset($request->variation)) {
                foreach (array_values($request->variation) as $variation_item) {
                    // dd($variation_item['amount']);
                    $couponVariation = CouponVariation::create([
                        'amount' => $variation_item['amount'],
                        'coupon_id' => $coupon->id
                    ]);
                    foreach ($variation_item['key'] as $variation_key) {
                        CouponVariationLic::create([
                            'key' => $variation_key,
                            'coupon_variation_id' => $couponVariation->id
                        ]);
                    }
                }
            }


            for ($i = 0; $i < count($request->lang); $i++) {
                CouponTranslation::insert(
                    [
                        [
                            'key' => 'name',
                            'value' => $request->{'name_' . $request->lang[$i]},
                            'lang' => $request->lang[$i],
                            'coupon_id' => $coupon->id
                        ],
                        [
                            'key' => 'refund_details',
                            'value' => $request->{'refund_details_' . $request->lang[$i]},
                            'lang' => $request->lang[$i],
                            'coupon_id' => $coupon->id
                        ],
                        [
                            'key' => 'description',
                            'value' => $request->{'description_' . $request->lang[$i]},
                            'lang' => $request->lang[$i],
                            'coupon_id' => $coupon->id
                        ],
                    ]
                );
            }

            DB::commit();


            return response()->json([
                'success' => true,
                'message' => 'Coupon successfully saved',
                'action' => 'redirect_to_url',
                'action_val' => route('coupon.list')
            ]);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Somthing Went Wrong',
                'debug' => $th->getMessage()
            ]);
        }
    }

    function UpdateStatus(Request $request)
    {

        $updateCoupon = Coupon::findOrFail($request->id);
        $updateCoupon->update([
            'status' => !$updateCoupon->status
        ]);

        return response()->json([
            'success' => true,
            'message' => __('coupon_status_successfully_updated')
        ], 200);
    }



    public function Delete(Request $request)
    {

        $deleteCoupon = Coupon::findOrFail($request->id);

        //update coupon
        $deleteCoupon->update([
            'isDeleted' => true
        ]);

        return response()->json([
            'success' => true,
            'action' => 'redirect_to_url',
            'action_val' => route('coupon.list'),
            'message' => __('coupon_successfully_deleted')
        ], 200);
    }
}
