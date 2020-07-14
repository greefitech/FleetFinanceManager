<?php

namespace App\Http\Controllers\API\DashboardController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
	/*
	*-------------------------------------
	* Dashboard api comtroller 
	*------------------------------------
	* This function consist of dashboard calculation for api
	*/


	public $successStatus = 200;


	/*
	*----------------------------------------------
	*Dashboard Summery Profit Expense
	*---------------------------------------------
	*Dashboard summary profit expense outstanging amount for api controller
	*/

    public function DashboardIncomeExpenseSummary() {
         $success['outstandingamount'] =  auth()->user()->get_outstanding_amount();
         if(!empty(request('month')) && !empty(request('year'))){ // if year and month 
			$month=request('month');$year=request('year');
			$prevmonth=\Carbon\Carbon::parse($year.'-'.$month.'-30')->subMonth()->format('m');$prevyear=\Carbon\Carbon::parse($year.'-'.$month.'-30')->subMonth()->format('Y');
			$prevmonth=\Carbon\Carbon::parse($year.'-'.$month.'-30')->subMonth()->format('m');$prevyear=\Carbon\Carbon::parse($year.'-'.$month.'-30')->subMonth()->format('Y');
			
			$success['nextmonth']=\Carbon\Carbon::parse($year.'-'.$month.'-30')->addMonths(1)->format('m');$success['nextyear']=\Carbon\Carbon::parse($year.'-'.$month.'-30')->addMonths(1)->format('Y');
        }else{ // empty month send current month data
        	$month=\Carbon\Carbon::now()->format('m');$year=\Carbon\Carbon::now()->format('Y');
         	$prevmonth=\Carbon\Carbon::now()->subMonth()->format('m');$prevyear=\Carbon\Carbon::now()->subMonth()->format('Y');
         	$success['nextmonth']=\Carbon\Carbon::now()->addMonths(1)->format('m');$success['nextyear']=\Carbon\Carbon::now()->addMonths(1)->format('Y');
        }

        $message = date("F", mktime(0, 0, 0, $month,10)).' - '.$year;
        $success['year'] =   $year;
     	$success['month'] =   $month;
     	$success['prevyear'] =   $prevyear;
     	$success['prevmonth'] =   $prevmonth;

        $success['profit']['amount'] = auth()->user()->CalculateProfitAmountTotal('',$month,$year);
        $success['profit']['prevamount'] = auth()->user()->CalculateProfitAmountTotal('',$prevmonth,$prevyear);

        $success['nonTripExpense']['amount'] = auth()->user()->CalculateNonTripExpenseAmountTotal('',$month,$year);
        $success['nonTripExpense']['prevamount'] = auth()->user()->CalculateNonTripExpenseAmountTotal('',$prevmonth,$prevyear);

         // $success['profit']['amount'] = 0;
         // $success['profit']['prevamount']=0;

        $amountbal = $success['profit']['amount'] - $success['profit']['prevamount'];
        if($amountbal < 0 && $success['profit']['prevamount'] != 0){
            $success['percentage']= ($amountbal / $success['profit']['prevamount']) * 100;
        }else if($amountbal > 0 && $success['profit']['prevamount'] != 0){
            $success['percentage']= ($amountbal / $success['profit']['amount']) * 100;
        }else if($amountbal != 0 && $success['profit']['prevamount'] == 0){
            $success['percentage'] = 100;
        }else{
            $success['percentage'] =   0;
        }
        $success['type'] =   ($success['percentage']>0) ?'success':'danger';

         return response()->json(['msg'=>$message,'data' => $success], $this->successStatus);
    }

    public function dashboardLastThreeMonthChart(){
    	$month=\Carbon\Carbon::now()->format('m');$year=\Carbon\Carbon::now()->format('Y');
        $prevmonth=\Carbon\Carbon::now()->subMonth()->format('m');$prevyear=\Carbon\Carbon::now()->subMonth()->format('Y');
        $prev2month=\Carbon\Carbon::now()->subMonth(2)->format('m');$prev2year=\Carbon\Carbon::now()->subMonth(2)->format('Y');

        $previous2month = date("M", mktime(0, 0, 0, $prev2month,10)).' - '.$prev2year;
        $success['chart'][0]['month'] = $previous2month;
        $success['chart'][0]['profit'] = auth()->user()->CalculateProfitAmountTotal('',$prev2month,$prev2year);
        $success['chart'][0]['expense'] = auth()->user()->CalculateNonTripExpenseAmountTotal('',$prev2month,$prev2year);


        $previousmonth = date("M", mktime(0, 0, 0, $prevmonth,10)).' - '.$prevyear;
        $success['chart'][1]['month'] = $previousmonth;
        $success['chart'][1]['profit'] = auth()->user()->CalculateProfitAmountTotal('',$prevmonth,$prevyear);
        $success['chart'][1]['expense'] = auth()->user()->CalculateNonTripExpenseAmountTotal('',$prevmonth,$prevyear);


        $currentmonth = date("M", mktime(0, 0, 0, $month,10)).' - '.$year;
        $success['chart'][2]['month'] = $currentmonth;
        $success['chart'][2]['profit'] = auth()->user()->CalculateProfitAmountTotal('',$month,$year);
        $success['chart'][2]['expense'] = auth()->user()->CalculateNonTripExpenseAmountTotal('',$month,$year);


		$message = $previous2month.' to '.$currentmonth.' Report';
        return response()->json(['msg'=>$message,'data' => $success], $this->successStatus);
    }


    /*
    *------------------------------------------
    *Dashboard Vehicle Wise List
    *------------------------------------------
    * Dashboard vehicle wise profit expense detail for month wise list
    */

    public function dashboardVehicleWiseList() {
        if(!empty(request('month')) && !empty(request('year'))){
			$month=request('month');$year=request('year');
			$prevmonth=\Carbon\Carbon::parse($year.'-'.$month.'-30')->subMonth()->format('m');$prevyear=\Carbon\Carbon::parse($year.'-'.$month.'-30')->subMonth()->format('Y');
			$prevmonth=\Carbon\Carbon::parse($year.'-'.$month.'-30')->subMonth()->format('m');$prevyear=\Carbon\Carbon::parse($year.'-'.$month.'-30')->subMonth()->format('Y');

			$success['nextmonth']=\Carbon\Carbon::parse($year.'-'.$month.'-30')->addMonths(1)->format('m');$success['nextyear']=\Carbon\Carbon::parse($year.'-'.$month.'-30')->addMonths(1)->format('Y');
        }else{
        	$month=\Carbon\Carbon::now()->format('m');$year=\Carbon\Carbon::now()->format('Y');
         	$prevmonth=\Carbon\Carbon::now()->subMonth()->format('m');$prevyear=\Carbon\Carbon::now()->subMonth()->format('Y');
         	$success['nextmonth']=\Carbon\Carbon::now()->addMonths(1)->format('m');$success['nextyear']=\Carbon\Carbon::now()->addMonths(1)->format('Y');
        }


        $message = date("F", mktime(0, 0, 0, $month,10)).' - '.$year.' Profit / Expense';

        $success['profitAmount'] =  auth()->user()->CalculateProfitAmountTotal('',$month,$year);
        $success['nonTripExpenseAmount'] =  auth()->user()->CalculateNonTripExpenseAmountTotal('',$month,$year);
        $success['month'] =  $month;
        $success['year'] =  $year;
        $success['prevmonth'] =  $prevmonth;
        $success['prevyear'] =  $prevyear;

        $success['vehicles']=array();
		foreach(auth()->user()->vehicles as $key=>$vehicle){
			$Profit = auth()->user()->CalculateProfitAmountTotal($vehicle->id,$month,$year);
			$NonExpense = auth()->user()->CalculateNonTripExpenseAmountTotal($vehicle->id,$month,$year);
			if($Profit > 0 || $NonExpense>0){
				$success['vehicles'][$key]['id'] = $vehicle->id;
				$success['vehicles'][$key]['vehicle_number'] = $vehicle->vehicleNumber;
				$success['vehicles'][$key]['profitAmount'] = $Profit;
				$success['vehicles'][$key]['nonTripExpenseAmount'] = $NonExpense;
				$success['vehicles'][$key]['status'] = ($Profit>$NonExpense)?'success':'danger';
			}
		}
        return response()->json(['msg'=>$message,'data' => $success], $this->successStatus);
    }
}
