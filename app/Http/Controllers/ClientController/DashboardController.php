<?php

namespace App\Http\Controllers\ClientController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboardTotalIncomeExpense(){
        $month= date('F', mktime(0, 0, 0, request()->month, 10));
        $final['Income'] = '<div class="inner">
                                <p>'.$month.'-'.request('year').' Profit</p>
                                <h3>'.auth()->user()->get_profit_amount(request('month'),request('year')).'</h3>
                            </div>
                            <div class="icon"><i class="ion ion-stats-bars"></i></div>
                            <a href="'.url('/client/dashboard/vehicleWiseCurrentMonthProfit/'.request('month').'/'.request('year')).'" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
        $final['expense'] = '<div class="inner">
                                <p>'.$month.'-'.request('year').' Expense</p>
                                <h3>'.auth()->user()->get_non_trip_expense(request('month'),request('year')).'</h3>
                            </div>
                            <div class="icon"><i class="ion ion-pie-graph"></i></div>
                            <a href="'.url('/client/dashboard/vehicleWiseCurrentMonthExpense/'.request('month').'/'.request('year')).'" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>';
        return $final;
    }
}
