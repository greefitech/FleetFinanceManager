<?php

namespace App\Http\Controllers\ClientController;

use App\FinancialIncdicator;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FinancialIndicatorController extends Controller
{
    public function add($VehicleId){
        $Data['Vehicle'] = Vehicle::findorfail($VehicleId);
        return view('client.master.vehicle.financial-indicator.add',$Data);
    }

    public function save($VehicleId){

        if(!empty(request('ExpenseData'))){
            $ExpenseValidator=[];
            foreach(request('ExpenseData') as $ExpenseKey=>$ExpenseDat){
                $ExpenseValidator['ExpenseData.'.$ExpenseKey.'.master_expense'] = 'required';
                if(isset(request('ExpenseData')[$ExpenseKey]['date'])){
                    foreach(request('ExpenseData')[$ExpenseKey]['date'] as $ExpenseInputKey=>$ExpenseDatete) {
                        $ExpenseValidator['ExpenseData.'.$ExpenseKey.'.amount.'.$ExpenseInputKey] = 'required|numeric|min:0';
                        $ExpenseValidator['ExpenseData.'.$ExpenseKey.'.expense.'.$ExpenseInputKey] = 'required';
                    }
                }
            }
            $this->validate(request(), $ExpenseValidator);
        }

        if(!empty(request('IncomeData'))){
            $IncomeData = [];
            $IncomeValidator=[];
            foreach(request('IncomeData')['date'] as $IncomeKey=>$IncomeData){
                $IncomeValidator['IncomeData.income.'.$IncomeKey] = 'required';
                $IncomeValidator['IncomeData.amount.'.$IncomeKey] = 'required|numeric|min:0';
            }
            $this->validate(request(), $IncomeValidator);
        }

        try {
            $FinantcialIndicator = new FinancialIncdicator;
            $FinantcialIndicator->vehicleId = $VehicleId;
            $FinantcialIndicator->expense = serialize(request('ExpenseData'));
            $FinantcialIndicator->income = serialize(request('IncomeData'));
            $FinantcialIndicator->clientid = auth()->user()->id;
            $FinantcialIndicator-> save();
            return redirect(route('client.ViewVehicles'))->with('success',['Financial Indicators','Created Successfully!']);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger','Something went wrong!! Finantial Indicator Already Added!');
        }
    }

    public function edit($FinancialId){
        $Data['FinancialIndicator'] = FinancialIncdicator::findorfail($FinancialId);
        $Data['Vehicle'] = Vehicle::findorfail($Data['FinancialIndicator']->vehicleId);
        return view('client.master.vehicle.financial-indicator.edit',$Data);
    }

    public function update($VehicleId,$FinancialID){

        if(!empty(request('ExpenseData'))){
            $ExpenseValidator=[];
            foreach(request('ExpenseData') as $ExpenseKey=>$ExpenseDat){
                $ExpenseValidator['ExpenseData.'.$ExpenseKey.'.master_expense'] = 'required';
                if(isset(request('ExpenseData')[$ExpenseKey]['date'])){
                    foreach(request('ExpenseData')[$ExpenseKey]['date'] as $ExpenseInputKey=>$ExpenseDatete) {
                        $ExpenseValidator['ExpenseData.'.$ExpenseKey.'.amount.'.$ExpenseInputKey] = 'required|numeric|min:0';
                        $ExpenseValidator['ExpenseData.'.$ExpenseKey.'.expense.'.$ExpenseInputKey] = 'required';
                    }
                }
            }
            $this->validate(request(), $ExpenseValidator);
        }

        if(!empty(request('IncomeData'))){
            $IncomeData = [];
            $IncomeValidator=[];
            foreach(request('IncomeData')['date'] as $IncomeKey=>$IncomeData){
                $IncomeValidator['IncomeData.income.'.$IncomeKey] = 'required';
                $IncomeValidator['IncomeData.amount.'.$IncomeKey] = 'required|numeric|min:0';
            }
            $this->validate(request(), $IncomeValidator);
        }

        try {
            $FinantcialIndicator = FinancialIncdicator::findorfail($FinancialID);
            $FinantcialIndicator->vehicleId = $VehicleId;
            $FinantcialIndicator->expense = serialize(request('ExpenseData'));
            $FinantcialIndicator->income = serialize(request('IncomeData'));
            $FinantcialIndicator->clientid = auth()->user()->id;
            $FinantcialIndicator-> save();
            return redirect(route('client.ViewVehicles'))->with('success',['Financial Indicators','Updated Successfully!']);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger','Something went wrong!! Finantial Indicator Already Added!');
        }
    }
}
