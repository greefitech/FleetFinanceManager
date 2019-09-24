<?php


/*Client Reference Name*/

use App\Admin;
use App\Client;
use App\VehicleCreditPayment;
use App\VehicleCredits;
use App\Entry;
use App\Expense;
use App\Income;
use App\ExtraIncome;

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
// /Bank Account Detail

if (! function_exists('VehicleCreditPaymentAccountWise')) {
    function VehicleCreditPaymentAccountWise($AccountId){
        $Entries  = Entry::where([['account_id',$AccountId],['clientid',auth()->user()->id]])->get();
        $Expenses = Expense::where([['account_id',$AccountId],['clientid',auth()->user()->id]])->get();
        $Incomes = Income::where([['account_id',$AccountId],['clientid',auth()->user()->id]])->get();
        $ExtraIncomes = ExtraIncome::where([['account_id',$AccountId],['clientid',auth()->user()->id]])->get();
        $Final['Credit'] = $Entries->sum('advance') + $Incomes->sum('recevingAmount') + $ExtraIncomes->sum('amount');
        $Final['Debit'] = $Expenses->sum('amount');
        return $Final;
    }
}


if (! function_exists('VehicleCreditPaymentAccountVehicleWise')) {
    function VehicleCreditPaymentAccountVehicleWise($AccountId,$VehicleId){
        $Entries  = Entry::where([['account_id',$AccountId],['vehicleId',$VehicleId],['clientid',auth()->user()->id]])->get();
        $Expenses = Expense::where([['account_id',$AccountId],['vehicleId',$VehicleId],['clientid',auth()->user()->id]])->get();
        $Incomes = Income::where([['account_id',$AccountId],['vehicleId',$VehicleId],['clientid',auth()->user()->id]])->get();
        $ExtraIncomes = ExtraIncome::where([['account_id',$AccountId],['vehicleId',$VehicleId],['clientid',auth()->user()->id]])->get();
        $Final['Credit'] = $Entries->sum('advance') + $Incomes->sum('recevingAmount') + $ExtraIncomes->sum('amount');
        $Final['Debit'] = $Expenses->sum('amount');
        return $Final;
    }
}