<?php

namespace App\Http\Controllers\AdminControllers;

use App\Client;
use App\VehicleCreditPayment;
use App\VehicleCredits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleCreditPaymentController extends Controller
{
    public function ViewVehicleCreditPayment(){
        $Data['VehicleCreditPayment'] = VehicleCreditPayment::get();
        return view('admin.VehicleCreditPayment.view',$Data);
    }

    public function AddVehicleCreditPayment(){
        if(auth()->user()->id ==1){
            $Data['Clients']=Client::get();
        }else{
            $Data['Clients']=Client::where([['referral_number',auth()->user()->mobile]])->get();
        }
        return view('admin.VehicleCreditPayment.add',$Data);
    }

    public function SaveVehicleCreditPayment(){
        $this->validate(request(),[
            'client_id'=>'required|exists:clients,id',
            'PaidAmount'=>'required',
        ]);
        try {
            $VehicleCreditPayment = new VehicleCreditPayment();
            $VehicleCreditPayment->client_id= request('client_id');
            $VehicleCreditPayment->PaidAmount= request('PaidAmount');
            $VehicleCreditPayment->Discount= request('Discount');
            if (auth()->user()->id != 1) {
                $VehicleCreditPayment->created_by = auth()->user()->id;
            }else{
                return $VehicleCreditPayment = VehicleCreditPayment::where('client_id','=',request('client_id'))->first()->get();
                return $VehicleCreditPayment->created_by = $VehicleCreditPayment->client_id;
            }
            $VehicleCreditPayment->save();
            return back()->with('success',['Payment','Added Sucessfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }

    public function getClientDetails(){
        if(!empty($Data['VehicleCredits'] = VehicleCredits::where('clientid',request('client_id'))->get())){
            $Data['VehicleCreditPayment'] = VehicleCreditPayment::where('client_id',request('client_id'))->get();
            return $Data;
        }else{
            return "No records";
        }

    }
}
