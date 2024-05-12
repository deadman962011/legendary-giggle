<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use Illuminate\Http\Request;

class NotificationController extends Controller
{


    public function List(Request $request)  {
        

        //
        $notifications = Notifications::all();

        return view('notification.list',compact('notifications'));



    }
    

    public function Create(Request $request) {
        
        return view('notification.new');



    }


    public function Store(Request $request) {


        //
        
        if ($request->has('image')) {
            // $image_name = Helpers::upload(dir:'notification/', format:'png', image: $request->file('image'));
        } else {
            $image_name = null;
        }

        // $notification =Notification::create([
        //     'title'=>$request->{'title_'.$request->lang[0]},
        //     'description'=>$request->{'description_'.$request->lang[0]}
        //     'image'=>
        //     'tergat'=>
        //     'zone_id'
        // ]);
        // $notification->title = $request->notification_title;
        // $notification->description = $request->description;
        // $notification->image = $image_name;
        // $notification->tergat= $request->tergat;
        // $notification->status = 1;
        // $notification->zone_id = $request->zone=='all'?null:$request->zone;
        // $notification->save();

        $topic_all_zone=[
            'customer'=>'all_zone_customer',
            'deliveryman'=>'all_zone_delivery_man',
            'restaurant'=>'all_zone_restaurant',
        ];

        $topic_zone_wise=[
            'customer'=>'zone_'.$request->zone.'_customer',
            'deliveryman'=>'zone_'.$request->zone.'_delivery_man',
            'restaurant'=>'zone_'.$request->zone.'_restaurant',
        ];
        $topic = $request->zone == 'all'?$topic_all_zone[$request->tergat]:$topic_zone_wise[$request->tergat];

        // if($request->has('image'))
        // {
        //     $notification->image = url('/').'/storage/app/public/notification/'.$image_name;
        // }

        // try {
        //     Helpers::send_push_notif_to_topic($notification, $topic, 'general');
        // } catch (\Exception $e) {
        //     info($e->getMessage());
        //     Toastr::warning(translate('messages.push_notification_faild'));
        // }






        
    }



}
