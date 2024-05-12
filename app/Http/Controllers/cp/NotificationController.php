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
        
    }



}
