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
        $IncomeAmount = auth()->user()->CalculateProfitAmountTotal('',$Month,$Year);
        $ExpenseAmount = auth()->user()->CalculateNonTripExpenseAmountTotal('',$Month,$Year);
        $final['Income'] = '<div class="inner">
                                <p>'.$month.'-'.$Year.' Income</p>
                                <h3>₹ '.$IncomeAmount.'</h3>
                            </div>
                            <div class="icon"><i class="ion ion-stats-bars"></i></div>
                            <a href="'.route('client.DashboardVehicleProfitTotal',[$Month,$Year]).'" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
        $final['expense'] = '<div class="inner">
                                <p>'.$month.'-'.$Year.' Expense</p>
                                <h3>₹ '.$ExpenseAmount.'</h3>
                            </div>
                            <div class="icon"><i class="ion ion-pie-graph"></i></div>
                            <a href="'.route('client.DashboardVehicleProfitTotal',[$Month,$Year]).'" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
        $final['Profit'] = '<div class="inner">
                <p>'.$month.'-'.$Year.' Profit</p>
                <h3>₹ '.($IncomeAmount - $ExpenseAmount).'</h3>
            </div>
            <div class="icon"><i class="ion ion-stats-bars"></i></div>
            <a href="'.route('client.DashboardVehicleProfitTotal',[$Month,$Year]).'" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
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
        $Data['Expenses'] =  Expense::where([['clientid', Auth::user()->id],['vehicleId',$VehicleId]])->whereYear('date', '=', $Year)->whereMonth('date', '=', $Month)->whereNull('tripId')->get();
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


    public function DashboardGetChartValues(){
        $MonthYear = explode('-',request('MonthYear'));
        $Year = $MonthYear[0];
        $Month = $MonthYear[1];

        $FinalData = array();
        array_push($FinalData,array('Month', 'Income', 'Expense'));
        for ($i=1; $i <= 12; $i++) { 
            $arrayName = array(
                date('F', mktime(0, 0, 0, $i, 10)),
                auth()->user()->CalculateProfitAmountTotal('',$i,$Year),
                auth()->user()->CalculateNonTripExpenseAmountTotal('',$i,$Year)
            );
            array_push($FinalData,$arrayName);
        }
        return response()->json(['year'=>$Year,'data'=>$FinalData]);
    }

    public function unPaidExpenseList(){
        $Data['Expenses']= Expense::where([['clientid', auth()->user()->id],['tripId', NULL],['status',0]])->get();
        return view('client.dashboard.unpaid-non-trip-expense',$Data);
    }
}
