<?php


namespace App\Services;

use App\Models\ApprovalRequest;
use App\Models\OfferInvoice;

class ApprovalService
{

    public function store($model, $data)
    {
        //save approval request 
        ApprovalRequest::create([
            'action' => 'create',
            'changes' => json_encode($data),
            'model' => $model,
        ]);
    }

    public function approve($data)
    { 
        switch ($data->model) {
            case 'shop':
                (new ShopService())->createShop(json_decode($data->changes),'approval');
                break;
            case 'offer':
                (new OfferService())->createOffer(json_decode($data->changes),'approval');
                break;
            case 'cancel_offer_invoice':
                $this->cancelOfferInvoice(json_decode($data->changes)); 
            default:
                break;
        }

        //update approval request status
        ApprovalRequest::where('id', $data->id)->update([
            'status' => 'approved'
        ]);
    }

    function reject($data)
    {

        ApprovalRequest::where('id',$data->id)->update([
            'status'=>'rejected'
        ]);

    }


    function check($model,$data,$state = ['pending']) {
        $approval_request=ApprovalRequest::whereIn('status',$state)->where('model',$model);
        
        if($data){
            $approval_request=$approval_request->whereJsonContains('changes',$data);
        };
        $approval_request=$approval_request->first();
        if($approval_request){
            return true;
        }
        return false;
    }



    public function cancelOfferInvoice($data) {
        
        $offer_invoice=OfferInvoice::where('offer_id',$data->offer_id)->where('id',$data->invoice_id)->firstOrFail();
        $offer_invoice->update([
            'isCanceled'=>true,
            'canceled_at'=>now()
        ]);
    }

}
