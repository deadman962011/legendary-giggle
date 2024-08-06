<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Http\Requests\cp\plan\savePlanRequest;
use App\Models\ShopSubscriptionPlan;
use App\Models\ShopSubscriptionPlanTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    //


    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:display_roles'])->only('List');
        $this->middleware(['permission:add_role'])->only(['Create', 'Store']);
        $this->middleware(['permission:edit_role'])->only(['Edit', 'Update']);
        $this->middleware(['permission:delete_role'])->only('Delete');
    }



    public function List(Request $request)
    {

        $plans = ShopSubscriptionPlan::active()->get();

        return view('plan.list', compact('plans'));
    }


    public function Create()
    {
        //
        // $permissions = Permission::where('guard_name', 'web')->get();
        return view('plan.new');
    }


    public function store(savePlanRequest $request)
    {

        try {

            DB::beginTransaction();

            $planId = ShopSubscriptionPlan::create([
                'name' => $request->{'name_' . $request->lang[0]},
                'price' => $request->price,
                'duration' => $request->duration,
                'isDeleted' => false
            ]);

            for ($i = 0; $i < count($request->lang); $i++) {
                ShopSubscriptionPlanTranslation::create([
                    'key' => 'name',
                    'value' => $request->{'name_' . $request->lang[$i]},
                    'lang' => $request->lang[$i],
                    'shop_subscription_plan_id' => $planId->id
                ],);
            }

            DB::commit();
            $response_data['success']    =   true;
            $response_data['message']   =  trans('Shop Subscription Plan Created Successfully');
            $response_data['action'] = 'redirect_to_url';
            $response_data['action_val']  =   route('plan.list');
            return response()->json($response_data);
 
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'payload' => null,
                'message' => 'Somthing Went Wrong',
                'debug'=>$th->getMessage()
            ], 200);
        }
    }


    function UpdateStatus(Request $request)
    {

        $updatePlan = ShopSubscriptionPlan::findOrFail($request->id);
        $updatePlan->update([
            'status' => !$updatePlan->status
        ]);

        return response()->json([
            'success' => true,
            'message' => __('plan_status_successfully_updated')
        ], 200);
    }



    public function Delete(Request $request)
    {

        $deletePlan = ShopSubscriptionPlan::findOrFail($request->id);

        //update category
        $deletePlan->update([
            'isDeleted' => true
        ]);

        return response()->json([
            'success' => true,
            'action' => 'redirect_to_url',
            'action_val' => route('plan.list'),
            'message' => __('plan_successfully_deleted')
        ], 200);
    }
}
