<?php

namespace App\Http\Controllers\ClientController;

use App\Expense;
use App\ExtraIncome;
use App\Trip;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function DashboardTotalIncomeExpense(){
        $MonthYear = explode('-',request('MonthYear'));
        $Year = $MonthYear[0];
        $Month = $MonthYear[1];
        $month= date('F', mktime(0, 0, 0, $Month, 10));
        $final['Income'] = '<div class="inner">
                                <p>'.$month.'-'.$Year.' Profit</p>
                                <h3>'.auth()->user()->CalculateProfitAmountTotal('',$Month,$Year).'</h3>
                            </div>
                            <div class="icon"><i class="ion ion-stats-bars"></i></div>
                            <a href="'.route('client.DashboardVehicleProfitTotal',[$Month,$Year]).'" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
        $final['expense'] = '<div class="inner">
                                <p>'.$month.'-'.$Year.' Expense</p>
                                <h3>'.auth()->user()->CalculateNonTripExpenseAmountTotal('',$Month,$Year).'</h3>
                            </div>
                            <div class="icon"><i class="ion ion-pie-graph"></i></div>
                            <a href="'.route('client.DashboardVehicleExpenseTotal',[$Month,$Year]).'" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
        return $final;
        
    }


    public function DashboardVehicleProfitTotal($Month,$Year){
        $Data['Month'] = $Month;
        $Data['Year']=$Year;
        return view('client.dashboard.ProfitVehicleListTotal',$Data);
    }

    public function DashboardVehicleProfitList($VehicleId,$Month,$Year){
        $Data['Vehicle'] = Vehicle::findorfail($VehicleId);
        $Data['Month'] = $Month;
        $Data['Year']=$Year;
        $Data['ExtraIncomes'] =  ExtraIncome::where([['clientid', Auth::user()->id],['vehicleId',  $VehicleId]])->whereYear('date', '=', $Year)->whereMonth('date', '=', $Month)->get();
        $Data['Trips'] = Trip::where([['clientid', Auth::user()->id],['vehicleId',  $VehicleId]])->whereYear('dateTo', '=', $Year)->whereMonth('dateTo', '=', $Month)->get();
        return view('client.dashboard.ProfitListDetail',$Data);
    }

    public function DashboardVehicleExpenseTotal($Month,$Year){
        $Data['Month'] = $Month;
        $Data['Year']=$Year;
        return view('client.dashboard.NonTripExpenseVehicleListTotal',$Data);
    }

    public function DashboardVehicleNonTripExpenseList($VehicleId,$Month,$Year){
        $Data['Vehicle'] = Vehicle::findorfail($VehicleId);
        $Data['Month'] = $Month;
        $Data['Year']=$Year;
        $Data['Expenses'] =  Expense::where([['clientid', Auth::user()->id],['vehicleId',$VehicleId]])->whereYear('date', '=', $Year)->whereMonth('date', '=', $Month)->whereNull('tripId')->get();
        return view('client.dashboard.NonTripExpenseDetail',$Data);
    }
}
