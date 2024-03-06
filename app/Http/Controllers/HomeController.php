<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function markNotification($id)
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
        $user = Auth::guard('admin')->user();
        $notification = $user->unreadNotifications;
        if ($notification) {
            $notification->markAsRead();
        return redirect()->route('admin.dashboard')->with('success','Notifikasi Sudah Terbaca');
        }
    }
}
