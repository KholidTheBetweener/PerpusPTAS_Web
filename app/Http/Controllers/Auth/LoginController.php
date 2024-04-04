<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }
    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'email'    => 'required|email|exists:admins|min:5|max:191',
            'password' => 'required|string|min:4|max:255',
        ];

        //custom validation error messages.
        $messages = [
            'email.exists' => 'These credentials do not match our records.',
        ];

        //validate the request.
        $request->validate($rules,$messages);
    }
    public function username(){
        return 'email';
    }
    public function showLoginForm()
    {
        return view('auth.login', [
            'title' => 'User Login',
            'loginRoute' => 'login',
            'forgotPasswordRoute' => 'password.request',
        ]);
    }
    public function showAdminLoginForm()
    {
        return view('auth.login', [
            'title' => 'Admin Login',
            'loginRoute' => 'admin.login',
            'forgotPasswordRoute' => 'admin.password.request',
        ]);
    }
    private function loginFailed(){
        return redirect()
            ->back()
            ->withInput()
            ->with('error','Login failed, please try again!');
    }

    public function adminLogin(Request $request)
    {
        $this->validator($request);
        if ($this->hasTooManyLoginAttempts($request)){
            //Fire the lockout event.
            $this->fireLockoutEvent($request);
    
            //redirect the user back after lockout.
            return $this->sendLockoutResponse($request);
        }
        if(\Auth::guard('admin')->attempt($request->only('email','password'),$request->filled('remember'))){
            //Authentication passed...
            return redirect()
                ->intended(route('admin.dashboard'))
                ->with('status','You are Logged in as Admin!');
        }
        $this->incrementLoginAttempts($request);
        return $this->loginFailed();
    }
    /*public function adminLogout(){
        \Auth::user->logout();
        return redirect('admin.login')->with('status','Admin has been logged out!');
    }*/
}
