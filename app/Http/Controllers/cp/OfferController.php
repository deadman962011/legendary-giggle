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

        // Staff Permission Check
        $this->middleware(['permission:edit_shop_offer','permission:delete_shop_offer'])->only('List');
        $this->middleware(['permission:add_shop_offer'])->only(['Create','Store']);
        $this->middleware(['permission:edit_shop_offer'])->only(['Edit','Update']);
        $this->middleware(['permission:delete_shop_offer'])->only('Delete');


    }

    //
    public function List(){

        //get categories
        $offers = Offer::where('isDeleted',false)->get();
        return view('offer.list',['offers'=>$offers]);

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
            $data['start_date']=strtotime($data['start_date']); 
            $data['end_date']=strtotime($data['end_date']); 
            
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
                'message'=>'Somthing Went Wrong',
                'debug'=>$th->getMessage()
            ]);
        }
    }

    public function Edit(){

    }
    

    public function Update(Request $request){

    }

    function UpdateStatus(Request $request)  {
        
        $updateOffer=Offer::findOrFail($request->id);
        $updateOffer->update([
            'status'=>!$updateOffer->status
        ]);
        
        return response()->json([
            'success'=>true,
            'message'=>__('offer_status_successfully_updated')
        ],200);

    }


    public function Delete(Request $request){

        $deleteOffer=Offer::findOrFail($request->id);

        //update category
        $deleteOffer->update([
            'isDeleted'=>true
        ]);

        return response()->json([
            'success'=>true,
            'action'=>'redirect_to_url',
            'action_val'=>route('offer.list'),
            'message'=>__('offer_successfully_deleted')
        ],200);

    }




}
