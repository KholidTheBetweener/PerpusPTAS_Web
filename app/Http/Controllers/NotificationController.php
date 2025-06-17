<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\User;
use App\Models\Admin;
use Notification;
use App\Notifications\RentApprove;
use App\Notifications\RentReject;
use App\Notifications\RentAlert;
use App\Notifications\RentOverdue;
use App\Notifications\RentReturn;
use App\Notifications\NewRentNotification;
use App\Notifications\NewUserNotification;

class NotificationController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth:admin');
    }
  
    /*public function index()
    {
        return view('product');
    }*/
    
    /*public function sendNotification() {
        $admin = Admin::all();
  $user = [
    'name' => 'BOGO',
    'body' => 'You received an offer.',
    'thanks' => 'Thank you',
    'offerText' => 'Check out the offer',
    'offerUrl' => url('/'),
    'offer_id' => 007
];
        Notification::send($admin, new NewUserNotification($user));
   
        dd('Task completed!');
    }*/
    /*public function markNotification($id)
    {
        $user = \Auth::guard('admin')->user();
        $notification = $user->notifications->where('id', $id)->first();
        //dd($notification);
        if ($notification) {
            $notification->markAsRead();
        return redirect()->route('admin.dashboard')->with('success','Notifikasi Sudah Terbaca');
        }
    }
    public function markAll(Request $request)
    {
        $user = \Auth::guard('admin')->user();
        $notification = $user->unreadNotifications;
        if ($notification) {
            $notification->markAsRead();
        return redirect()->route('admin.dashboard')->with('success','Semua Notifikasi Sudah Terbaca');
        }
    }*/    
}
