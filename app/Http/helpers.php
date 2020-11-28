<?php

use App\Client;
use App\ExpenseType;
use App\Manager;
use App\Vehicle;
use App\VehicleCredits;
use App\Tyre;
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

if (! function_exists('GetVendorOption')) {
    function GetVendorOption(){
        $vendorsData='';
        foreach(auth()->user()->vendors as $vendor){
            $vendorsData = $vendorsData.'<option value="'.$vendor->id.'">'.$vendor->name.' | '.$vendor->mobile.'</option>';
        }
        return $vendorsData;
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

/*Check File is exsists or not*/
if (! function_exists('PublicFolderFileExsits')) { 
    function PublicFolderFileExsits($FileLocation) { 
        if (!empty($FileLocation) && file_exists( public_path() . '/'.$FileLocation)) {
            return 1;
        } 
        return 0; 
    } 
}

if (! function_exists('GetNonUsedTyreList')) {
    function GetNonUsedTyreList(){
        return Tyre::where([['clientid',auth()->user()->id],['tyre_status','!=',0],['is_sold',0]])->WhereNull('vehicleId')->get();
    }
}

/*==================================
    String Replace scroll start -> mohan
===================================*/

if (! function_exists('stringReplaceScroll')) {
    function stringReplaceScroll($string){
        $stringHasBracketsAuth = preg_match_all('/\{(.*?)\}/i', $string,  $matchOutput);
        if ($stringHasBracketsAuth) {
            $string = preg_replace_callback('/\{(.*?)}/', function ($m) {
                return strval(authuser($m[1])); 
            }, $string);
        }
        $stringHasBracketsUrl = preg_match_all('/\#\url\((.*?)\)\#/i', $string,  $matchOutput);
        if ($stringHasBracketsUrl) {
            $string = preg_replace_callback('/\#url\((.*?)\)\#/i', function ($m) {
                return url($m[1]); 
            }, $string);
        }
        $stringHasBracketsConfig = preg_match_all('/\#config\((.*?)\)\#/i', $string,  $matchOutput);
        if ($stringHasBracketsConfig) {
            $string = preg_replace_callback('/\#config\((.*?)\)\#/i', function ($m) {
                return strval(config($m[1])); 
            }, $string);
        }
        $stringHasBracketsDate = preg_match_all('/\#date\((.*?)\)\#/i', $string,  $matchOutput);
        if ($stringHasBracketsDate) {
            $string = preg_replace_callback('/\#date\((.*?)\)\#/i', function ($m) {
                return ChangeDateFormate($m[1]); 
            }, $string);
        }
        $stringHasBracketsEnv = preg_match_all('/\#env\((.*?)\)\#/i', $string,  $matchOutput);
        if ($stringHasBracketsEnv) {
            $string = preg_replace_callback('/\#env\((.*?)\)\#/i', function ($m) {
                return env($m[1]); 
            }, $string);
        }
        return $string;
    }
}

if (! function_exists('authuser')) {
    function authuser($string){
        return Auth::user()->$string;
    }
}

if (! function_exists('ChangeDateFormate')) {
    function ChangeDateFormate($string){
        return date("d-m-Y", strtotime($string));
    }
}
/*==================================
    String Replace scroll end -> mohan
===================================*/