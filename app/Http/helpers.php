<?php

use App\ExpenseType;
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

if (! function_exists('GetExpenseTypes')) {
    function GetExpenseTypes(){
        return ExpenseType::where([['clientid',auth()->user()->id]])->orWhereNull('clientid')->where([['id' ,'!=',1],['id' ,'!=',2],['id' ,'!=',4],['id' ,'!=',6],['id' ,'!=',12]])->get();
    }
}


if (! function_exists('GetAccountsOption')) {
    function GetAccountsOption(){
        $AccountsData='';
        foreach(auth()->user()->Accounts as $Account){
            return $AccountsData = $AccountsData.'<option value="'.$Account->id.'">'.$Account->account.' - '.$Account->HolderName.'</option>';
        }
        return $AccountsData;
    }
}


if (! function_exists('GetCustomersOption')) {
    function GetCustomersOption(){
        $CustomersData='';
        foreach(auth()->user()->customers as $Customer){
            return $CustomersData = $CustomersData.'<option value="'.$Customer->id.'">'.$Customer->name.'</option>';
        }
        return $CustomersData;
    }
}