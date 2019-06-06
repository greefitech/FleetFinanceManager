<?php


/*Client Reference Name*/

use App\Admin;
use App\Client;
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
if (! function_exists('AdminVehicleCreditsAdminVehicleCredits')) {
    function AdminVehicleCredits($AdminID){
        return $Data['VehicleCredits'] = VehicleCredits::where('created_by',$AdminID)->get();
    }
}


/*Get Admin Vehicle Credit Payment deleted*/
if (! function_exists('AdminVehicleBalanceAmount')) {
    function AdminVehicleBalanceAmount($AdminMobile){
        $BalanceAmount=0;
        if(empty($AdminMobile)){
            $Clients = Client::whereNull('referral_number')->get();
        }else{
            $Clients = Client::where([['referral_number',$AdminMobile]])->get();
        }
        foreach ($Clients as $Client){
            $BalanceAmount += ClientTotalBalancePaymentCreditAmount($Client->id);
        }
        return $BalanceAmount;
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



/*Get Balance Payment Client Wise*/
if (! function_exists('ClientTotalBalancePaymentCreditAmount')) {
    function ClientTotalBalancePaymentCreditAmount($ClientId){
        $VehicleCredit = VehicleCreditsClientWise($ClientId);
        $VehicleCreditPayment = VehicleCreditPaymentClientWise($ClientId);
        return $VehicleCredit->sum('total_amount') - ($VehicleCredit->sum('paid_amount') + $VehicleCreditPayment->sum('PaidAmount') + $VehicleCreditPayment->sum('Discount'));
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