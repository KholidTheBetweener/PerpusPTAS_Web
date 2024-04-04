<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Password;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Auth\Notifications\ResetPassword;

class AdminForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Only guests for "admin" guard are allowed except
     * for logout.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    /**
     * Show the reset email form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm(){
        return view('auth.passwords.email',[
            'title' => 'Admin Password Reset',
            'passwordEmailRoute' => 'admin.password.email'
        ]);
    }
    //->with('user_type', request()->user_type)

    /**
     * password broker for admin guard.
     * 
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker(){
        return Password::broker('admins');
    }

    /*public function sendEmail(Request $request) {
        ResetPassword::createUrlUsing(function ($user, string $token){
         return route('admin.password.reset', compact($token));
        });
        $this->sendRequestLinkEmail($request);
    }*/

    /**
     * Get the guard to be used during authentication
     * after password reset.
     * 
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    public function guard(){
        return Auth::guard('admin');
    }
}
