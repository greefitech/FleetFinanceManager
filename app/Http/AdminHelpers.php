<?php


/*Client Reference Name*/

use App\Admin;
use App\VehicleCreditPayment;
use App\VehicleCredits;

if (! function_exists('GetClientReferenceName')) {
    function GetClientReferenceName($ClientReferenceNumber){
        if(!empty($ClientReferenceNumber)){
            if(!empty($Admin = Admin::where('mobile',$ClientReferenceNumber)->first())){
                return $Admin->name;
            } else{
                return $ClientReferenceNumber;
            }
        }else{
            return auth()->user()->name;
        }
    }
}

/*Trip Sheet List Select for client*/
if (! function_exists('TripSheet')) {
    function TripSheet(){
        return array(
            array('DefaultTripSheet','Default'),
            array('KPRTripsheet','KPR Trip Sheet')
        );
    }
}


/*Get Admin Vehicle Credit Payment*/
if (! function_exists('AdminVehicleCredits')) {
    function AdminVehicleCredits($AdminID){
        return $Data['VehicleCredits'] = VehicleCredits::where('created_by',$AdminID)->get();
    }
}


/*Get Admin Vehicle Credit Payment*/
if (! function_exists('AdminVehicleCreditPayment')) {
    function AdminVehicleCreditPayment($AdminID){
        return VehicleCreditPayment::where('created_by',$AdminID)->get();
    }
}

/*Vehicle Credit Client Wise*/
if (! function_exists('VehicleCreditsClientWise')) {
    function VehicleCreditsClientWise($ClientId){
        return VehicleCredits::where('clientid',$ClientId)->get();
    }
}
/*Vehicle Credit Payment Client Wise*/
if (! function_exists('VehicleCreditPaymentClientWise')) {
    function VehicleCreditPaymentClientWise($ClientId){
        return VehicleCreditPayment::where('client_id',$ClientId)->get();
    }
}