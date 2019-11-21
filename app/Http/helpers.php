<?php

use App\Client;
use App\ExpenseType;
use App\Manager;
use App\Vehicle;
use App\VehicleCredits;
use Carbon\Carbon;

if (! function_exists('DateDifference')) {
    function DateDifference($Date){
        if (!empty($Date)) {
            return Carbon::now()->diffInDays($Date, false);
        } else {
            return '-';
        }
    }
}

if (! function_exists('GetExpenseTypesOption')) {
    function GetExpenseTypesOption(){
        $ExpenseData='';
        $ExpenseTypes = ExpenseType::where([['clientid',auth()->user()->id]])->orWhereNull('clientid')->where([['id' ,'!=',1],['id' ,'!=',2],['id' ,'!=',4],['id' ,'!=',6],['id' ,'!=',12]])->get();
        foreach($ExpenseTypes as $ExpenseType){
            $ExpenseData = $ExpenseData.'<option value="'.$ExpenseType->id.'">'.$ExpenseType->expenseType.'</option>';
        }
        return $ExpenseData;
    }
}

if (! function_exists('ManagerGetExpenseTypesOption')) {
    function ManagerGetExpenseTypesOption(){
        $ExpenseData='';
        $ExpenseTypes = ExpenseType::where([['clientid',auth()->user()->Owner->id]])->orWhereNull('clientid')->where([['id' ,'!=',1],['id' ,'!=',2],['id' ,'!=',4],['id' ,'!=',6],['id' ,'!=',12]])->get();
        foreach($ExpenseTypes as $ExpenseType){
            $ExpenseData = $ExpenseData.'<option value="'.$ExpenseType->id.'">'.$ExpenseType->expenseType.'</option>';
        }
        return $ExpenseData;
    }
}

if (! function_exists('GetExpenseTypes')) {
    function GetExpenseTypes(){
        return ExpenseType::where([['clientid',auth()->user()->id]])->orWhereNull('clientid')->where([['id' ,'!=',1],['id' ,'!=',2],['id' ,'!=',4],['id' ,'!=',6],['id' ,'!=',12]])->get();
    }
}


if (! function_exists('GetAccountsOption')) {
    function GetAccountsOption(){
        $AccountsData='';
        foreach(auth()->user()->Accounts as $Account){
            $AccountsData = $AccountsData.'<option value="'.$Account->id.'">'.$Account->account.' - '.$Account->HolderName.'</option>';
        }
        return $AccountsData;
    }
}


if (! function_exists('GetCustomersOption')) {
    function GetCustomersOption(){
        $CustomersData='';
        foreach(auth()->user()->customers as $Customer){
            $CustomersData = $CustomersData.'<option value="'.$Customer->id.'">'.$Customer->name.' | '.$Customer->mobile.'</option>';
        }
        return $CustomersData;
    }
}

if (! function_exists('GetRTOMasterDataInputs')) {
    function GetRTOMasterDataInputs(){
        $Cal = (request('type') == 'RTO')?request('type').'Data':request('type');
        try {
            $RtoMasterInput='';
            $RTOMaster = \App\RTOMaster::findorfail(request('rtoid'));
            $RTOMasterDatas = unserialize($RTOMaster->description);
            foreach($RTOMasterDatas['location'] as $MasterKey=>$RTOMasterData){
                 $RtoMasterInput = $RtoMasterInput.'<tr>
                        <td>
                            <input type="text" class="form-control" style="width: 15em" value="'.$RTOMasterDatas['location'][$MasterKey].'" placeholder="Enter Location" name="'.request('type').'Data[location][]">
                        </td>
                        <td>
                            <input type="text" class="form-control '.$Cal.'AmountValue" style="width: 15em" value="'.$RTOMasterDatas['amount'][$MasterKey].'" placeholder="Enter Amount" name="'.request('type').'Data[amount][]">
                        </td>
                        <td class="RemoveRToInput" style="font-size: 18px;"><i style="color: red;" class="fa fa-close fa-10x"></i></td>
                    </tr>';
                    ;
            }
            return $RtoMasterInput;

        }catch (Exception $e){
            return 'error';
        }
    }
}


if (! function_exists('GetClientManager')) {
    function GetClientManager($ClientId){
        return Client::where('id',$ClientId)->get()->first();
    }
}

if (! function_exists('GetClientVehicle')) {
    function GetClientVehicle($ClientId){
        $clientid = Client::findorfail($ClientId);
        return Vehicle::where('clientid',$clientid->id)->get();
    }
}

//RTO MASTER
if (! function_exists('MemoMasterType')) {
    function MemoMasterType(){
        return array('rto' => 'RTO','pc'=>'PC' );
    }
}




if (! function_exists('demoss')) {
    function demoss(){
        $FinalData = array();
        array_push($FinalData,array('Month', 'Income', 'Expense'));
        for ($i=1; $i <= 12; $i++) { 
            $arrayName = array(date('F', mktime(0, 0, 0, $i, 10)),$i,rand(1,20));
            array_push($FinalData,$arrayName);
        }
        return response()->json(['month'=>request('MonthYear'),'data'=>$FinalData]);
    }
}