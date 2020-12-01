<?php

namespace App\Http\Controllers\ManagerApi\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use App\Manager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
  

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $errorMsg['status'] = 'error';
            foreach ($validator->errors()->toArray() as $value) {
               $errorMsg['error'][]=$value[0];
            }
            return response()->json(['status'=>'error','data'=>$errorMsg], 401);
        }


        $Manager = Manager::where('mobile',request('email'))->first();
        if (!empty($Manager)) {
            if (!Hash::check(request('password'), @$Manager->password)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return Auth::login($Manager);
            if(Auth::guard('manager')->login($Manager)){
                return response( array( "message" => "Sign In Successful", "data" => [
                    "manager" => $Manager,
                    "token" => $Manager->createToken('Personal Access Token',['customer'])->accessToken
                ]  ), 200 );
            } else {
                return response( array( "message" => "Wrong Credentials." ), 422 );
            }
        } else {
            return response( array( "message" => "No User." ), 422 );
        }



    }

    public function demo(){
        return auth()->user();
    }

   
}
