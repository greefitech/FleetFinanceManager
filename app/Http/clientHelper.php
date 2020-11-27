<?php

use App\Trip;
use App\ExtraIncome;
use App\Entry;
use App\Expense;
use App\VendorExpensePayment;

/*
/---------------------------------------------------
/the function containing the calculation for income and expense for month
/---------------------------------------------------
*/


/*Calculate profit amount for each client vehicle wise*/
if (! function_exists('CalculateProfitAmountTotalVehicleWise')) {
 	function CalculateProfitAmountTotalVehicleWise($VehicleId,$month,$year,$ClientId){
        $Trips = Trip::where([['clientid', $ClientId],['vehicleId',  $VehicleId]])->whereYear('dateTo', '=', $year)->whereMonth('dateTo', '=', $month)->get();
        $total_income =0;
        foreach ($Trips as $Trip){
            $total_income += (TripTotalIncome($Trip->id,$ClientId) - TripTotalExpense($Trip->id,$ClientId));
        }
        return $total_income+ExtraIncome::where([['clientid', $ClientId],['vehicleId',  $VehicleId]])->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->sum('amount');
    }
}


/*Calculate profit amount for each client for all vehicle*/
if (! function_exists('CalculateProfitAmountTotalClientWise')) {
 	function CalculateProfitAmountTotalClientWise($month,$year,$ClientId){
        $Trips= Trip::where('clientid', $ClientId)->whereYear('dateTo', '=', $year)->whereMonth('dateTo', '=', $month)->get();
        $total_income =0;
        foreach ($Trips as $Trip){
            $total_income += (TripTotalIncome($Trip->id,$ClientId) - TripTotalExpense($Trip->id,$ClientId));
        }
        return $total_income+ExtraIncome::where('clientid', $ClientId)->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->sum('amount');
    }
}


/*Calculate trip total income amount*/
if (! function_exists('TripTotalIncome')) {
	function TripTotalIncome($tripId,$ClientId){
        @$total_entry_amount = Entry::where([['clientid', $ClientId],['tripId',$tripId]])->sum('billAmount');
        return $total_entry_amount;
    }
}


/*Calculate trip total expense amount*/
if (! function_exists('TripTotalExpense')) {
    function TripTotalExpense($tripId,$ClientId){
        @$total_comission_amount = Entry::where([['clientid', $ClientId],['tripId',$tripId]])->sum('comission');
        @$total_loadingMamool_amount = Entry::where([['clientid', $ClientId],['tripId',$tripId]])->sum('loadingMamool');
        @$total_unLoadingMamool_amount = Entry::where([['clientid', $ClientId],['tripId',$tripId]])->sum('unLoadingMamool');
        @$total_expense_amount = Expense::where([['clientid', $ClientId],['tripId',$tripId], ['status',1]])->sum('amount');
        $entryDatas = Entry::where([['tripId',$tripId]])->get();
        $Trip= Trip::findorfail($tripId);
        return $total_comission_amount+$total_loadingMamool_amount+$total_unLoadingMamool_amount+$total_expense_amount + @$entryDatas->sum('driverPadiAmount')  + @$entryDatas->sum('cleanerPadiAmount');
    }
}


/*Calculate non trip expense client vehicle wise*/
if (! function_exists('CalculateNonTripExpenseAmountTotalVehicleWise')) {
	function CalculateNonTripExpenseAmountTotalVehicleWise($VehicleId,$month,$year,$ClientId){
        return Expense::where([['clientid', $ClientId],['vehicleId',$VehicleId]])->where('tripId', NULL)->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->sum('amount');
        
    }
}


/*Calculate non trip expense client total*/
if (! function_exists('CalculateNonTripExpenseAmountTotalClientWise')) {
	function CalculateNonTripExpenseAmountTotalClientWise($month,$year,$ClientId){
        return Expense::where('clientid', $ClientId)->where('tripId', NULL)->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->sum('amount');
    }
}



/*Vehicle Monthly vehicle wise trip count*/
if (! function_exists('vehicleMontlyVehicleWiseTripDetail')) {
    function vehicleMontlyVehicleWiseTripDetail($VehicleId,$month,$year,$ClientId){
        $Trip = Trip::where([['clientid', $ClientId],['vehicleId',  $VehicleId]])->whereYear('dateTo', '=', $year)->whereMonth('dateTo', '=', $month)->get();
        $Data['tripCount'] = $Trip->count();
        $Data['tripTotalKm'] = $Trip->sum('totalKm');
        return $Data;
    }
}

/*Vehicle monthly client trip count*/
if (! function_exists('vehicleMontlyClientWiseTripDetail')) {
    function vehicleMontlyClientWiseTripDetail($month,$year,$ClientId){
        $Trip = Trip::where([['clientid', $ClientId]])->whereYear('dateTo', '=', $year)->whereMonth('dateTo', '=', $month)->get();
        $Data['tripCount'] = $Trip->count();
        $Data['tripTotalKm'] = $Trip->sum('totalKm');
        return $Data;
    }
}


/*Vehicle Monthly Expense*/
if (! function_exists('vehicleMontlyVehicleWiseTripExpenseDetail')) {
    function vehicleMontlyVehicleWiseTripExpenseDetail($VehicleId,$month,$year,$ClientId,$ExpenseId){
        $Expense = Expense::where([['clientid', $ClientId],['vehicleId',  $VehicleId],['tripId', NULL]])->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->get();
        $Data['quantity'] = $Expense->sum('quantity');
        $Data['amount'] = $Expense->sum('amount');
        return $Data;
    }
}

/*Vehicle Client Monthly Expense */
if (! function_exists('vehicleMontlyClientWiseTripExpenseDetail')) {
    function vehicleMontlyClientWiseTripExpenseDetail($month,$year,$ClientId,$ExpenseId){
        $Expense = Expense::where([['clientid', $ClientId],['tripId', NULL]])->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->get();
        $Data['quantity'] = $Expense->sum('quantity');
        $Data['amount'] = $Expense->sum('amount');
        return $Data;
    }
}


/*Check Duplicate Trip Entry*/
if (! function_exists('CheckTripDuplicateEntry')) {
    function CheckTripDuplicateEntry($TripId,$VehicleId,$dateFrom,$DateTo){
        $Trip = Trip::where([['dateFrom',$dateFrom],['dateTo',$DateTo],['vehicleId',$VehicleId],['clientid',auth()->user()->id],['id','!=',$TripId]])->first();
        if (!empty($Trip)) {
            return '<span class="label label-danger">Duplicate Entry</span>';
        }
        return '';
    }
}

/*Unpaid paid expense list*/
if (! function_exists('nonTripUnpaidExpneseTotal')) {
    function nonTripUnpaidExpneseTotal($ClientId){
        return Expense::where([['clientid', $ClientId],['tripId', NULL],['status',0]])->sum('amount');
        
    }
}


/*=========================
    Client Vendor Payment
===========================*/


/*Unpaid paid expense list*/
if (! function_exists('vendorUnpaidExpenseList')) {
    function vendorUnpaidExpenseList($ClientId,$vendorId){
        $Expense = Expense::where([['clientid', $ClientId],['vendor_id', $vendorId],['status',0]])->sum('amount');
        $VendorExpensePayment= VendorExpensePayment::where([['clientid', $ClientId],['vendor_id', $vendorId]])->sum('amount');
        return $Expense - $VendorExpensePayment;
    }
}
