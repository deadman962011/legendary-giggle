<?php

namespace App\Http\Controllers\api\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\offer\saveOfferRequest;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Services\ApprovalService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShopOfferController extends Controller
{

    protected $approvalService;

    public function __construct(ApprovalService $approvalService)
    {
        $this->approvalService = $approvalService;
    }



    function List(Request $request)
    {
        $user=Auth::guard('shop')->user();

        $offers = Offer::where('shop_id', $user->shop_id)->where('isDeleted', false)->get();
        
        return response()->json([
            'success' => true,
            'payload' =>OfferResource::collection($offers),
            'message' => 'Offers Successfully Loaded'
        ], 200);
    }

    function Store(saveOfferRequest $request)
    {

        $data = $request->all();
        $data['start_date'] = strtotime($request->start_date);
        $data['end_date'] = strtotime($request->end_date);
        $data['shop_id']=Auth::guard('shop')->user()->shop_id;

        try {

            DB::beginTransaction();
            $this->approvalService->store('offer', $data);
            DB::commit();
            return response()->json([
                'success' => true,
                'payload' => null,
                'message' => 'Offer registration request successfully saved'
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
        }
    }
}
