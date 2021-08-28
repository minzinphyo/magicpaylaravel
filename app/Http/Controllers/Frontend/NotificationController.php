<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(){

        $authUser = Auth::guard('web')->user();
        $notifications = $authUser->notifications()->paginate(5);
        return view('frontend.notification',compact('notifications'));
    }

    public function show($id){
        $authUser = Auth::guard('web')->user();
        $notification = $authUser->notifications()->where('id',$id)->firstOrFail();
        $notification->markAsRead();
        return view('frontend.notification_detail',compact('notification'));
    }
}
