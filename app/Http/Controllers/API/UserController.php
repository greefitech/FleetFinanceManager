<?php
namespace App\Http\Controllers\API;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Client;


class UserController extends Controller
{
    public $successStatus = 200;
    /**
     * @SWG\Post(
     *     path="/api/login",
     *     description="Login with Email / Mobile",
     *     tags={"Clients"},
     *     @SWG\Parameter(
     *         name="email",
     *         in="query",
     *         type="string",
     *         format="email",
     *         description="Enter Email / Mobile",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="query",
     *         type="string",
     *         format="password",
     *         description="Enter Password",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Data"
     *     )
     * )
     */

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('GREEFITECH')-> accessToken;
            $success['name'] =  $user->name;
            $success['transportName'] =  $user->transportName;
            return response()->json(['status'=>'success','data' => $success], $this->successStatus);
        }else if(Auth::attempt(['mobile' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('GREEFITECH')-> accessToken;
            $success['name'] =  $user->name;
            $success['transportName'] =  $user->transportName;
            return response()->json(['status'=>'success','data' => $success], $this->successStatus);
        } else{
            $errormsg['msg'] = 'Invalid Email/Mobile or Password';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
    }


    /**
     * @SWG\Post(
     *     path="/api/register",
     *     description="Register User",
     *     tags={"Clients"},
     *     @SWG\Parameter(
     *         name="name",
     *         in="query",
     *         type="string",
     *         description="Enter Name",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="email",
     *         in="query",
     *         type="string",
     *         format="email",
     *         description="Enter Email",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="mobile",
     *         in="query",
     *         type="string",
     *         format="number",
     *         description="Enter Mobile",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="transportName",
     *         in="query",
     *         type="string",
     *         description="Enter Transport Name",
     *         required=true,
     *     ),
     *      @SWG\Parameter(
     *         name="address",
     *         in="query",
     *         type="string",
     *         description="Enter Address",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="query",
     *         type="string",
     *         description="Enter Password",
     *         required=true,
     *     ),
     *
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Data"
     *     )
     * )
     */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:clients',
            'mobile' => 'required|min:10|max:10|unique:clients',
            'transportName' => 'required|max:255',
            'address' => 'required|max:255',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            $errormsg['msg'] = 'Email or Phonenumber already registered';
            return response()->json(['status'=>'error','data'=>$errormsg], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['expires_on'] = Helper::get_expire_date(date('Y'));
        $user = Client::create($input);
        $success['token'] =  $user->createToken('GREEFITECH')-> accessToken;
        $success['name'] =  $user->name;
        return response()->json(['status'=>'success','data'=>$success], $this->successStatus);
    }

}