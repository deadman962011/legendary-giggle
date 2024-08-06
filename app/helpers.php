<?php

use App\Models\Setting;
 use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Container\Container;
use App\Models\Upload;


if (!function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        // return app('url')->asset('public/' . $path, $secure);

        return app('url')->asset($path, $secure);
        // if (env('FILESYSTEM_DRIVER') == 's3') {
        //     return Storage::disk('s3')->url($path);
        // } else {
        //     // $base_path = @explode('/' , $path)[0];
        //     // if($base_path == 'storage')
        //     // {
        //     //     return app('url')->asset($path, $secure);
        //     // }
        // }
    }


    if (!function_exists('generate_random_token')) {
        /**
         * Generate a random token.
         *
         * @param int $length
         * @return string
         */
        function generate_random_token($length = 32)
        {
            return Str::random($length);
        }
    }


    if (!function_exists('getFileUrl')) {
        /**
         * Get Uploaded File Url.
         *
         * @return string
         */
        function getFileUrl($id)
        {
            $item = Upload::findOrFail($id);

            return url($item->file_name);
        }
    }


    if (!function_exists('getSetting')) {
        /**
         * Get Setting Value.
         *
         * @param string $key
         * @return string
         */
        function getSetting($key)
        {
            $item = Setting::where('key', $key)->firstOrFail();

            return $item->value;
        }
    }


    if (!function_exists('send_push_notif_to_topic')) {


        function send_push_notif_to_topic($data, $topic, $type, $web_push_link = null)
        {

            $key = Setting::where('key', 'firebase_push_notification_key')->first()->value;

            $url = "https://fcm.googleapis.com/fcm/send";
            $header = array(
                "authorization: key=" . $key . "",
                "content-type: application/json"
            );

            $click_action = "";
            if ($web_push_link) {
                $click_action = ',
            "click_action": "' . $web_push_link . '"';
            }
           
           
            $data=[
                'to' => '/topics/' . $topic,
                'mutable_content'=> true,
                'data' => [
                    'title' => $data['title'],
                    'body' => $data['description'],
                    'image' => $data['image'],
                    'is_read'=> 0,
                    'type' => $type
                ],
                'notification' => [
                    'title' => $data['title'],
                    'body' => $data['description'],
                    'image' => $data['image'],
                    'body_loc_key' => $type,
                    'type' => $type,
                    'is_read'=> 0,
                    'icon' => 'new',
                    'sound' => 'notification.wav',
                    'android_channel_id' => 'mybill',
                    $click_action
                ]
            ];

            $postdata=json_encode($data);

            // $postdata = '{
            //     "to" : "/topics/' . $topic . '",
            //     "mutable_content": true,
            //     "data" : {
            //         "title":"' . $data['title'] . '",
            //         "body" : "' . $data['description'] . '",
            //         "image" : "' . $data['image'] . '",
            //         "is_read": 0,
            //         "type":"' . $type . '",
            //     },
            //     "notification" : {
            //         "title":"' . $data['title'] . '",
            //         "body" : "' . $data['description'] . '",
            //         "image" : "'  . array_key_exists('image', $data->toArray()) && $data['image'] !== null ? getFileUrl($data['image']) : '' . '",
            //         "body_loc_key":"' . $type . '",
            //         "type":"' . $type . '",
            //         "is_read": 0,
            //         "icon" : "new",
            //         "sound": "notification.wav",
            //         "android_channel_id": "mybill"
            //         ' . $click_action . '
            //       }
            // }';
            
            // dd($postdata);
                    
            $ch = curl_init();
            $timeout = 120;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

            // Get URL content
            $result = curl_exec($ch);
            $responseBody = json_decode($result, true);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // close handle to release resources
            curl_close($ch);
            return $result;
        }
    }




    if (!function_exists('send_push_notif_to_multiple_users')) {


        function send_push_notif_to_multiple_users($notification_data, $tokens, $type, $web_push_link = null)
        {
            
            $key = Setting::where('key', 'firebase_push_notification_key')->first()->value;

            $url = "https://fcm.googleapis.com/fcm/send";
            $header = array(
                "authorization: key=" . $key . "",
                "content-type: application/json"
            );

            $click_action = "";
            if ($web_push_link) {
                $click_action = ',
            "click_action": "' . $web_push_link . '"';
            }


            $data=[
                'registration_ids'=> $tokens,
                'mutable_content'=>true,
                'data'=>[
                    'title'=>$notification_data['title'],
                    'body'=>$notification_data['description'],
                    'image'=>$notification_data['image'],
                    'is_read'=>0,
                    'type'=>$type

                ] ,
                'notification'=>[
                    'title'=>$notification_data['title'],
                    'body'=>$notification_data['description'],
                    'image'=>array_key_exists('image', $notification_data) && $notification_data['image'] !== '' ? getFileUrl($notification_data['image']) : '',
                    'body_loc_key'=>$type,
                    'type'=>$type,
                    'is_read'=>0,
                    'icon'=>'new',
                    'sound'=>'notification.wav',
                    'android_channel_id'=>'mybill',
                    $click_action
                ] 
            ];

            if($type ==='cashback_recived'){
                // dd($data)
                $data['data']['cashback_amount'] = $notification_data['cashback_amount'];
                $data['data']['offer_id'] = $notification_data['offer_id'];
            }

            $postdata =json_encode($data);

            // $postdata = '{
            //     "registration_ids" : ' . $tokens . ',
            //     "mutable_content": true,
            //     "data" : {
            //         "title":"' . $data['title'] . '",
            //         "body" : "' . $data['description'] . '",
            //         "image" : "' . $data['image'] . '",
            //         "is_read": 0,
            //         "type":"' . $type . '",
            //     },
            //     "notification" : {
            //         "title":"' . $data['title'] . '",
            //         "body" : "' . $data['description'] . '",
            //         "image" : "'  . array_key_exists('image', $data->toArray()) && $data['image'] !== null ? getFileUrl($data['image']) : '' . '",
            //         "body_loc_key":"' . $type . '",
            //         "type":"' . $type . '",
            //         "is_read": 0,
            //         "icon" : "new",
            //         "sound": "notification.wav",
            //         "android_channel_id": "mybill"
            //         ' . $click_action . '
            //       }
            // }';
            
            // dd($postdata);
                    
            $ch = curl_init();
            $timeout = 120;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

            // Get URL content
            $result = curl_exec($ch);
            $responseBody = json_decode($result, true);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // close handle to release resources

            curl_close($ch);
            return $result;
        }
    }





    if (!function_exists('paginateCollection')) {
        function paginateCollection(Collection $results, $perPage)
        {
    
            $pageNumber = Paginator::resolveCurrentPage('page');
            $items = $results->forPage($pageNumber, $perPage);
            $total = $results->count();
            $currentPage = $pageNumber;
            $options = [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ];
    
            return Container::getInstance()->makeWith(
                LengthAwarePaginator::class,
                compact(
                    'items',
                    'total',
                    'perPage',
                    'currentPage',
                    'options'
                )
            );
    
        }
    }
    



}
