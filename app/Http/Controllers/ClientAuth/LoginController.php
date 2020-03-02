<?php

namespace App\Http\Controllers\ClientAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Carbon\Carbon;
use App\ClientLogActivity;

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

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/client/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

//     public function login(Request $request){
//         $this->validate($request, [
//             'email'           => 'required|max:255',
//             'password'           => 'required',
// //            'captcha'        => 'required|captcha'
//         ]);

//         if(is_numeric(request('email'))){
//             if (Auth::guard('client')->attempt(['mobile' => $request->email, 'password' => $request->password])) {
//                 return redirect()->intended('/client/home');
//             } else {
//                 return redirect()->back();
//             }
//         }
//         elseif (filter_var(request('email'), FILTER_VALIDATE_EMAIL)) {
//             if (Auth::guard('client')->attempt(['email' => $request->email, 'password' => $request->password])) {
//                 return redirect()->intended('/client/home');
//             } else {
//                 return redirect()->back();
//             }
//         }
//         if (Auth::guard('client')->attempt(['mobile' => $request->email, 'password' => $request->password])) {
//             return redirect()->intended('/client/home');
//         } else {
//             return redirect()->back();
//         }
//     }

  

    public function __construct()
    {
        $this->middleware('client.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */

    protected function credentials(){
        if(is_numeric(request()->get('email'))){
            return ['mobile'=>request()->get('email'),'password'=>request()->get('password')];
        }
        elseif (filter_var(request()->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => request()->get('email'), 'password'=>request()->get('password')];
        }
        return ['mobile' => request()->get('email'), 'password'=>request()->get('password')];
    }

    public function authenticated(Request $request, $user){
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);
        ClientLogActivity::create([
            'subject' => 'login',
            'url' =>  $request->fullUrl(),
            'method' =>  $request->method(),
            'ip' =>  $request->ip(),
            'agent' =>  $request->header('user-agent'),
            'client_id' => $user->id,
        ]);
        return redirect()->intended($this->redirectPath());
    }

    public function showLoginForm()
    {
        return view('client.auth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('client');
    }
}
