<?php

namespace App\Http\Controllers\API\DashboardController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

	public $successStatus = 200;


    public function outstandingBalanceTotal() {
         $success['outstandingamount'] =  auth()->user()->get_outstanding_amount();
         if(!empty(request('month')) && !empty(request('year'))){
			$month=request('month');$year=request('year');
			$prevmonth=\Carbon\Carbon::parse($year.'-'.$month.'-30')->subMonth()->format('m');$prevyear=\Carbon\Carbon::parse($year.'-'.$month.'-30')->subMonth()->format('Y');
         }else{
         	$month=\Carbon\Carbon::now()->format('m');$year=\Carbon\Carbon::now()->format('Y');

         	$prevmonth=\Carbon\Carbon::now()->subMonth()->format('m');$prevyear=\Carbon\Carbon::now()->subMonth()->format('Y');
         }
        $message = date("F", mktime(0, 0, 0, $month,10)).' - '.$year;
     	$success['profit']['amount'] =  auth()->user()->CalculateProfitAmountTotal('',$month,$year);
     	$success['profit']['prevamount'] =  auth()->user()->CalculateProfitAmountTotal('',$prevmonth,$prevyear);
     	$success['profit']['yearmonth'] =   $message;
     	$success['profit']['year'] =   $year;
     	$success['profit']['month'] =   $month;







     	$success['nonTripExpense']['amount'] =  auth()->user()->CalculateNonTripExpenseAmountTotal('',$month,$year);
     	$success['nonTripExpense']['prevamount'] =  auth()->user()->CalculateNonTripExpenseAmountTotal('',$prevmonth,$prevyear);
     	$success['nonTripExpense']['yearmonth'] =  $message;
     	$success['nonTripExpense']['year'] =   $year;
     	$success['nonTripExpense']['month'] =   $month;

     	// return (1 - ($success['profit']['prevamount']-$success['nonTripExpense']['prevamount']) / ($success['profit']['amount'] - $success['nonTripExpense']['amount'])) * 100;



         return response()->json(['msg'=>$message,'data' => $success], $this->successStatus);
    }






}
