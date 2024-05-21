<?php

namespace App\Http\Controllers\cp;

use App\Http\Controllers\Controller;
use App\Http\Requests\cp\notification\saveNotificationRequest;
use App\Models\Notification;
use App\Models\NotificationTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{


    public function List(Request $request)
    {

        //
        $notifications = Notification::all();
        return view('notification.list', compact('notifications'));
    }


    public function Create(Request $request)
    {

        return view('notification.new');
    }


    public function Store(saveNotificationRequest $request)
    {
        //
        try {

            DB::beginTransaction();
            $notification = Notification::create([
                'title' => $request->{'title_' . $request->lang[0]},
                'description' => $request->{'description_' . $request->lang[0]},
                'image' => $request->image,
                'target' => $request->target,
                'zone_id' => $request->zone_id == 'all' ? null : $request->zone_id
            ]);

            $topic_all_zone = [
                'customer' => 'all_zone_customer',
                'shop' => 'all_zone_shop',
            ];

            $topic_zone_wise = [
                'customer' => 'zone_' . $request->zone_id . '_customer',
                'shop' => 'zone_' . $request->zone_id . '_shop',
            ];

            $topic = $request->zone_id == 'all' ? $topic_all_zone[$request->target] : $topic_zone_wise[$request->target];

            for ($i = 0; $i < count($request->lang); $i++) {
                NotificationTranslation::insert(
                    [
                        [
                            'key' => 'name',
                            'lang' => $request->lang[$i], //default language
                            'value' => $request->{"title_" . $request->lang[$i]},
                            'notification_id' => $notification->id
                        ],
                        [
                            'key' => 'description',
                            'lang' => $request->lang[$i], //default language
                            'value' => $request->{"description_" . $request->lang[$i]},
                            'notification_id' => $notification->id
                        ]
                    ]
                );
            }

            send_push_notif_to_topic($notification, $topic, 'general');

            DB::commit();
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Notifcation Successfully Sent',
                    'action' => 'redirect_to_url',
                    'action_val' => route('notification.list')
                ]
            );
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Somthing went wrong'
                ]
            );
        }
    }
}
