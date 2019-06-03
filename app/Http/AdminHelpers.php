<?php


/*Client Reference Name*/

use App\Admin;
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
        return VehicleCredits::where('created_by',$AdminID)->get();
    }
}

/*Vehicle Credit Client Wise*/
if (! function_exists('VehicleCreditsClientWise')) {
    function VehicleCreditsClientWise($ClientId){
        return VehicleCredits::where('clientid',$ClientId)->get();
    }
}