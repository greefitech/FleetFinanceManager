<?php

namespace App\Http\Controllers\AdminControllers;

use App\Client;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientControllers extends Controller
{

    public function __construct(){
        $this->middleware('admin');
    }

    public function ClientList(){
        if(auth()->user()->id ==1){
            $Data['Clients']=Client::get();
        }else{
            $Data['Clients']=Client::where([['referral_number',auth()->user()->mobile]])->get();
        }
        return view('admin.ClientList.ViewAllClients',compact('Data'));
    }

    public function VehicleLists($id){
        $Data['Clients']=Client::findorfail($id);
        $Data['Vehicles']=Vehicle::where([['clientid',$id]])->get();
        return view('admin.ClientList.ViewAllVehicles',compact('Data'));
    }

    public function EditClient($id){
        $Data['Client']=Client::findorfail($id);
        return view('admin.ClientList.editClient',compact('Data'));
    }

    public function UpdateClientDeteils($id){
        try {
            $Client=Client::findorfail($id);
            $Client->name=request()->name;
            $Client->transportName=request()->transportName;
            $Client->mobile=request()->mobile;
            $Client->address=request()->address;
//            $Client->vehicleCredit=request()->vehicleCredit;
            $Client->save();
            return back()->with('success',['Client','Updated Sucessfully!']);
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }

    }

    public function deleteVehicle($id){
        try{
            return back()->with('danger','Something went wrong!');
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function deleteCustomer($id){
        try{
            return back()->with('danger','Something went wrong!');
        }catch (\Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
