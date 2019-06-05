<?php

namespace App\Http\Controllers\AdminControllers;

use App\Client;
use App\VehicleCredits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleCreditControllers extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function add(){
        if(auth()->user()->id ==1){
            $Data['Clients']=Client::get();
        }else{
            $Data['Clients']=Client::where([['referral_number',auth()->user()->mobile]])->get();
        }
        return view('admin.vehicleCredit.AddVehicleCredit',compact('Data'));
    }


    public function SaveVehicleCredit(){
        $this->validate(request(),[
            'credit'=>'required|min:1|numeric',
            'base_price'=>'required',
            'clientid'=>'required|exists:clients,id',
        ]);
        try {
            $VehicleCredits = new VehicleCredits();
            $VehicleCredits->clientid=request('clientid');
            $VehicleCredits->credit=request('credit');
            $VehicleCredits->base_price=request('base_price');
            $VehicleCredits->total_amount=request('credit')*request('base_price');
            $VehicleCredits->paid_amount=request('paid_amount');
            $VehicleCredits->created_by=auth()->user()->id;
            $VehicleCredits->save();

            $client = Client::findorfail(request()->clientid);
            $client->vehicleCredit = $client->vehicleCredit+request('credit');
            $client->save();

            return back()->with('success',['Vehicle Credit','Added Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }
}
