<?php

namespace App\Http\Controllers\ClientAuth;

use App\Account;
use App\Client;
use App\Helpers\Helper;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

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
            'referral_number' => 'required|min:10|max:10',
            'transportName' => 'required|max:255',
            'address' => 'required|max:255',
            'password' => 'required|min:6|confirmed',
//            'captcha' => 'required|captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Client
     */
    protected function create(array $data)
    {
//         dd($data);
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
        return $clients;
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
