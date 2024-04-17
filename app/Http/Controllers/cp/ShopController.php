<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Http\Requests\cp\shop\saveShopRequest;
use App\Models\Category;
use App\Models\Shop;
use App\Services\ShopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{


    protected $shopService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    //

    public function List(Request $request)
    {

        //
        $shops = Shop::where('isDeleted', 0)->get();
        return view('shop.list', ['shops' => $shops]);
    }


    public function Create()
    {

        //
        $categories = Category::where('isDeleted', 0)->get();
        return view('shop.new', compact('categories'));
    }

    function Store(saveShopRequest $request)
    {
        $data = $request->all();
        $data['categories_ids'] = implode(',', $request->categories_ids);

        try {
            
            DB::beginTransaction();            
            $this->shopService->createShop(json_decode(json_encode($data)),'cp');
            DB::commit();
            return response()->json([
                'success' => true,
                'payload' => null,
                'action' => 'redirect_to_url',
                'action_val' => route('shop.list'),
                'message' => 'Shop successfully saved'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing Went Wrong'
            ], 200);
        }
    }
}
