<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Models\ApprovalRequest;
use App\Services\ApprovalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    //
    protected $approvalService;

    public function __construct(ApprovalService $approvalService)
    {
        $this->approvalService = $approvalService;
        
        $this->middleware(['permission:approval_shops','permission:approval_offers'])->only('List');
    }


    public function List(Request $request){
        //
        $model = $request->model;
        $status = $request->status;
        $action=$request->action;
        $approval_requests=ApprovalRequest::where(function($query) use($model,$status,$action) {
            $query->where('status',$status)->where('model',$model)->where('action',$action);
        })->get();
        
        return view('approval.list',['approval_requests'=>$approval_requests]);
    }

    public function Show(Request $request){
        
        //
        $approval_request=ApprovalRequest::where('id',$request->id)->firstOrFail();
        return view('approval.show',['approval_request'=>$approval_request]);

    }


    function Handle(Request $request) {
        DB::beginTransaction();
        try {
            $approval_request=ApprovalRequest::where('id',$request->id)->firstOrFail();
            if($request->action==='approve'){
                $this->approvalService->approve($approval_request);
            }
            else if($request->action==='reject'){
                $this->approvalService->reject($approval_request);
            }
            else{
                throw 'action is not valid ';
            }
            DB::commit();
            return response()->json([
                'success'=>true,
                'message'=>'Approval request sucessfully '.$request->action,
                'action'=>'redirect_to_url',
                'action_val'=> route('approval.list',['status'=>'pending','model'=>$approval_request->model,'action'=>$approval_request->action])
            ]);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return response()->json([
                'success'=>false,
                'message'=>'Somthing went wrong',
            ]);
        }
        


    }

    // function Approve(Request $request) {
    
    // }

    // function Reject(Request $request)  {
        
    
    //     try {
    //         DB::beginTransaction();
    //         $approval_request=ApprovalRequest::where('id',$request->id)->firstOrFail();
    
    //         $this->approvalService->reject($approval_request);
    //         DB::commit();
    //         return response()->json([
    //             'success'=>true,
    //             'message'=>'Approval request sucessfully Rejected',
    //             'action'=>'redirect_to_url',
    //             'action_val'=> route('approval.list',['status'=>'pending','model'=>$approval_request->model,'action'=>$approval_request->action])
    //         ]);
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         dd($th);
    //         return response()->json([
    //             'success'=>false,
    //             'message'=>'Somthing went wrong',
    //         ]);
    //     }

    // }









}
