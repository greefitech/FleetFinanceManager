<?php
namespace App\Http\Controllers\API;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Client;
use Carbon\Carbon;
use App\ClientLogActivity;



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

    public function login(Request $request){
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

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])  || Auth::attempt(['mobile' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            Client::findorfail($user->id)->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $request->getClientIp(),
                'firebase_token' => request('firebase_token')
            ]);
            ClientLogActivity::create([
                'subject' => 'login_app',
                'url' =>  $request->fullUrl(),
                'method' =>  $request->method(),
                'ip' =>  $request->ip(),
                'agent' =>  $request->header('user-agent'),
                'client_id' => $user->id,
            ]);

            if($user->verified == 1){
                 $success['token'] =  $user->createToken('GREEFITECH')->accessToken;
                 $success['user'] =  $user;
                 $success['user']['profile_image'] = (!empty($user->profile_image) && PublicFolderFileExsits($user->profile_image))?url($user->profile_image):url(config('mohan.website_logo'));
                 return response()->json(['msg'=>'Login Success','data' => $success], $this->successStatus);
            }else{
                return response()->json(['msg'=>'Account Not Yet Verified Check Email To Verify Account!!'], 401); 
            }
        } else{ 
            $UserLogin = Client::where('email', request('email'))->orWhere('mobile', request('email'))->first();
            if($UserLogin == null) {
                return response()->json(['msg'=>'Incorrect Email / Mobile Number'], 401); 
            } else {
                return response()->json(['msg'=>'Incorrect Password'], 401); 
            }  
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

    public function register(Request $request){
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
            $errorMsg['status'] = 'error';
            foreach ($validator->errors()->toArray() as $value) {
                $errorMsg['error'][]=$value[0];
            }
            return response()->json(['status'=>'error','data'=>$errorMsg], 401);
        }
        
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['expires_on'] = Helper::get_expire_date(date('Y'));
        $user = Client::create($input);
        // $success['token'] =  $user->createToken('GREEFITECH')-> accessToken;
       return response()->json(['msg'=>'User Registered Success'], $this->successStatus);
    }

    /*User Profile */
    public function profile(Request $request){
        $success['client'] = auth()->user();
        return response()->json(['msg'=>'Client List','data' =>$success], $this-> successStatus);
    }


    /*Logout User */
    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json(['msg'=>'Logout Success'], $this->successStatus);
    }
}