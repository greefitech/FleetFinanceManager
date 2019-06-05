<?php

namespace App\Http\Controllers\AdminControllers;

use App\Client;
use App\VehicleCreditPayment;
use App\VehicleCredits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleCreditPaymentController extends Controller
{

    public function add(){
        if(auth()->user()->id ==1){
            $Data['Clients']=Client::get();
        }else{
            $Data['Clients']=Client::where([['referral_number',auth()->user()->mobile]])->get();
        }
        return view('admin.vehicleCredit.VehicleCreditPayment',$Data);
    }

    public function SaveVehicleCreditPayment(){
        $this->validate(request(),[
            'client_id'=>'required|exists:clients,id',
        ]);

        /*Check the balance amount exceed the payment amount*/
        $VehicleCreditDetail = VehicleCredits::where('clientid',request('client_id'))->get();
        $VehicleCreditPayment = VehicleCreditPayment::where('client_id',request('client_id'))->get();
        $TotalPaidAmount = $VehicleCreditDetail->sum('paid_amount') + $VehicleCreditPayment->sum('PaidAmount') + $VehicleCreditPayment->sum('Discount');
        $Balance = $VehicleCreditDetail->sum('total_amount') - $TotalPaidAmount;

        if($Balance < (request('PaidAmount') + request('Discount')) || $Balance<=0){
            return back()->with('sorry','Check The Balance Amount!!');
        }

        if((request('PaidAmount') + request('Discount')) <= 0){
            return back()->with('sorry','Nill Amount To Pay!!');
        }

        try {
            $VehicleCreditPayment = new VehicleCreditPayment();
            $VehicleCreditPayment->client_id= request('client_id');
            $VehicleCreditPayment->PaidAmount= request('PaidAmount');
            $VehicleCreditPayment->Discount= request('Discount');
            $VehicleCreditPayment->created_by = auth()->user()->id;
            $VehicleCreditPayment->save();
            return back()->with('success',['Credit Payment','Added Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
    }


    public function getClientDetails(){
        if(!empty($VehicleCreditDetail = VehicleCredits::where('clientid',request('client_id'))->get())){
            $Data['TotalVehicleCredit'] = $VehicleCreditDetail->sum('credit');
            $Data['TotalAmount'] = $VehicleCreditDetail->sum('total_amount');
            $VehicleCreditPayment = VehicleCreditPayment::where('client_id',request('client_id'))->get();

            $Data['TotalPaidAmount'] = $VehicleCreditDetail->sum('paid_amount') + $VehicleCreditPayment->sum('PaidAmount') + $VehicleCreditPayment->sum('Discount');
            $Data['BalanceAmount'] = $Data['TotalAmount'] - $Data['TotalPaidAmount'];

            return $Data;
        }else{
            return "error";
        }

    }
}
