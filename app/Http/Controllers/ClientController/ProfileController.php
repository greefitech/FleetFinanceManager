<?php

namespace App\Http\Controllers\ClientController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Client;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    /*
     * Update Profile Page
     */
    public function profile(){
        return view('client.setting.profile.profile');
    }

    /*
     * Update Profile
     */

    public function UpdateProfile(Request $request){
        $this->validate(request(),[
            'name'=>'required',
            'mobile'=>'required|min:10|max:10|unique:clients,mobile,'.auth()->user()->id,
            'transportName' => 'required',
            'address' => 'required',
        ],[
            'mobile.unique'=>'Please Check Mobile Number and Update.Contact Admin!'
        ]);
        try {
            if ($files = $request->file('profile_image')) {
                $StoragePath = '/assets/logo/'; // upload path
                $profileImage = date('YmdHis') .auth()->user()->name. "." . $files->getClientOriginalExtension();
                $files->move(public_path() .$StoragePath, $profileImage);
            }

            $Client = Client::findorfail(auth()->user()->id);
            $Client->name = request('name');
            $Client->mobile = request('mobile');
            $Client->transportName = request('transportName');
            $Client->address = request('address');
            if(!empty($profileImage)) {
                if (!empty($Client->profile_image)){
                    unlink(public_path() . '/assets/logo/' . $Client->profile_image);
                }
                $Client->profile_image = $profileImage;
            }
            // else{
            //     unlink(public_path() . '/assets/logo/' . $Client->profile_image);
            //     $Client->profile_image = '';
            // }
            $Client->save();
            return back()->with('success',['Profile','Updated Successfully!!']);
        }catch (Exception $e){
            return back()->with('sorry','Sorry,Profile Not Found!');
        }
    }

    /*
     * Change User Password page
     */
    public function ChangePassword(){
        return view('client.setting.profile.ChangePassword');
    }

    /*
     * Change User Password page
     */
    public function UpdatePassword(){
        $this->validate(request(), [
            'old_password'     => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $Client = Client::findorfail(auth()->user()->id);
        if(!Hash::check(request('old_password'), $Client->password)){
            return back()->with('sorry','Old Password And New Password Cannot Be matched');
        }else{
            $Client->password = bcrypt(request('password'));
            $Client->save();
            return back()->with('success',['Profile','Updated Successfully!!']);
        }
    }
}
