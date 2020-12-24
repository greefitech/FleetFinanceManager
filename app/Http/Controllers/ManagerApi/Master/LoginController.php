<?php

namespace App\Http\Controllers\ManagerApi\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use App\Manager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller{

    public $successStatus = 200;

    public function __construct(){
        
    }


    /*=======================
        Manager Login Verification
    =========================*/
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $value) {
                return response()->json(['status'=>'error','msg'=>$value[0]], 422);
            }
        }

        if(Auth::guard('manager')->attempt(['mobile' => request('email'), 'password' => request('password')], false, false)) {
            $Manager = auth()->guard('manager')->user();
            $success['token'] =  $Manager->createToken('GREEFITECH')-> accessToken;
            $success['manager'] =  $Manager;
            $success['transportName'] =  $Manager->Owner->transportName;
            return response()->json(['msg'=>'Login Success','data' => $success], $this->successStatus);
        }else{ 
            $ManagerLogin = Manager::where('email', request('email'))->orWhere('mobile', request('email'))->first();
            if($ManagerLogin == null) {
                return response()->json(['msg'=>'Incorrect Email / Mobile Number'], 422); 
            } else {
                return response()->json(['msg'=>'Incorrect Password'], 422); 
            }  
        }
    }

    public function demo(){
        return auth()->user();
    }


    /*========================
        Manager Logout 
    ==========================*/
    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json(['msg'=>'Logout Success'], $this->successStatus);
    }
}
