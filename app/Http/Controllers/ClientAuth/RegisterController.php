<?php

namespace App\Http\Controllers\ClientAuth;

use App\Account;
use App\Client;
use App\Helpers\Helper;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use App\VerifyClient;
use App\Mail\VerifyClientMail;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/client/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('client.guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:clients',
            'mobile' => 'required|min:10|max:10|unique:clients',
            'transportName' => 'required|max:255',
            'address' => 'required|max:255',
            'password' => 'required|min:6|confirmed',
            'referral_number' => 'nullable|min:10|max:10',
            //'captcha' => 'required|captcha',
        ]);
    }


    /*
    *--------------------------------------------------------
    * Verify User Function
    *--------------------------------------------------------
    *This function is used for an email verification for client on production state
    */

    public function VerifyClient($token){
        $VerifyClient = VerifyClient::where('token', $token)->first();
        if(isset($VerifyClient) ){
            $Client = $VerifyClient->Client;
            if(!$Client->verified) {
                $Client->verified = 1;
                $Client->save();
                $status = "Your e-mail is verified. You can now login.";
            }else{
                $status = "Your e-mail is already verified. You can now login.";
            }
        }else{
            return redirect('/client/login')->with('warning', "Sorry your email cannot be identified.");
        }
        return redirect('/client/login')->with('status', $status);
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Client
     */
    protected function create(array $data)
    {
        $clients = Client::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'transportName' => $data['transportName'],
            'expires_on' => Helper::get_expire_date(date('Y')),
            'address' => $data['address'],
            'referral_number' => $data['referral_number'],
            'password' => bcrypt($data['password'])
        ]);
        Account::create([
            'account' =>'IOC',
            'HolderName'=>$data['name'],
            'clientid' => $clients->id,
        ]);

        VerifyClient::create([
            'client_id' => $clients->id,
            'token' => sha1(time())
        ]);
        if(env('APP_ENV') =='production'){
            \Mail::to($clients->email)->send(new VerifyClientMail($clients));
        }

        return $clients;
    }

    /*
    *------------------------------------------------------
    * Email Verification on register
    *------------------------------------------------------
    * On production state after client register the client will logout automatically
    */

    protected function registered(Request $request, $user){
        if(env('APP_ENV') =='production'){
            $this->guard('client')->logout();
            return redirect('/client/login')->with('status', 'We sent you an activation code. Check your email and click on the link to verify.');
        }
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('client.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('client');
    }
}
