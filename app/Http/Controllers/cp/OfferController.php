<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OfferService;
use App\Models\Offer;
use App\Models\Shop;
use App\Http\Requests\cp\offer\saveOfferRequest;
use Illuminate\Support\Facades\DB;
class OfferController extends Controller
{

    
    protected $offerService;

    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }

    //
    public function List(){

        //get categories
        $categories = Offer::where('isDeleted',false)->get();
        return view('category.list',['categories'=>$categories]);

    }

    public function Create(){
        
        //get parent categories
        $shops=Shop::where('isDeleted',false)->where('status',true)->get();
        return view('offer.new',['shops'=>$shops]);

    }
    
    public function Store(saveOfferRequest $request){

        
        $data = $request->all();
        try {

            DB::beginTransaction();            
            $this->offerService->createOffer(json_decode(json_encode($data)),'cp');
            DB::commit();

            return response()->json([
                'success'=>true,
                'message'=>'offer successfully saved',
                'action'=>'redirect_to_url',
                'action_val'=>route('offer.list')
            ]);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success'=>false,
                'message'=>'Somthing Went Wrong'
            ]);
        }
    }

    public function Edit(){

    }

    public function Update(Request $request){

    }

    public function Delete(Request $request){

    }




}
