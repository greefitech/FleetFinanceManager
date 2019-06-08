<?php

namespace App\Http\Controllers\AdminControllers;

use App\Client;
use App\Vehicle;
use App\VehicleCredits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ClientControllers extends Controller
{

    public function __construct(){
        $this->middleware('admin');
    }

    public function ClientList(){
        if(auth()->user()->id == 1){
            $Data['Clients']=Client::get();
        }else{
            $Data['Clients']=Client::where([['referral_number',auth()->user()->mobile]])->get();
        }
        return view('admin.ClientList.ClientList',$Data);
    }

    public function VehicleLists($id){
        try {
            $Data['Client']=Client::findorfail($id);
            if(auth()->user()->id != 1){
                if($Data['Client']->referral_number != auth()->user()->mobile){
                    return back();
                }
            }
            $Data['Vehicles']=Vehicle::where([['clientid',$id]])->get();
            return view('admin.ClientList.ViewAllVehicles',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function EditClient($id){
        try {
            $Data['Client']=Client::findorfail($id);
            if(auth()->user()->id != 1){
                if($Data['Client']->referral_number != auth()->user()->mobile){
                    return back();
                }
            }
            return view('admin.ClientList.editClient',$Data);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function UpdateClientDetails($id){
        $this->validate(request(),[
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:clients,email,'.$id,
            'transportName' => 'required',
            'mobile' => 'required|min:10|max:10|unique:clients,mobile,'.$id,
            'address' => 'required|max:255',
            'password' => 'nullable|min:6|confirmed',
        ]);
        try {
            $Client=Client::findorfail($id);
            $Client->name=request()->name;
            $Client->transportName=request()->transportName;
            $Client->mobile=request()->mobile;
            $Client->address=request()->address;
            $Client->memosheet=request('memosheet');
            if(!empty(request('password'))){
                $Client->password = bcrypt(request('password'));
            }
            $Client->save();
            return back()->with('success',['Client','Updated Successfully!']);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }

    }

    public function ClientVehicleCreditDetails($ClientId){
        try {
            $Data['Client'] = Client::findorfail($ClientId);
            if(auth()->user()->id != 1){
                if($Data['Client']->referral_number != auth()->user()->mobile){
                    return back();
                }
            }
            $Data['VehicleCredits'] = VehicleCredits::where([['clientid',$ClientId]])->get();
            return view('admin.ClientList.ClientVehicleCreditDetails',$Data);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
