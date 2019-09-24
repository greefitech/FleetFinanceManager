@extends('manager.layout.master')

@section('content')

        <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-4 col-xs-12">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <p>Out Standing Amount</p>
{{--                                    <h3>{{ auth()->user()->get_outstanding_amount() }}</h3>--}}
                                    <h3>0</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-xs-12">
                            <!-- small box -->
                            <div class="small-box bg-green" id="DashboardIncome">
                                <div class="inner">
                                    <p>{{ date('M-Y') }} Profit</p>
{{--                                    <h3>{{ auth()->user()->CalculateProfitAmountTotal('',date('m'),date('Y')) }}</h3>--}}
                                    <h3>0</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-xs-12">
                            <div class="small-box bg-red" id="DashboardExpense">
                                <div class="inner">
                                    <p>{{ date('M-Y') }} Expense</p>
{{--                                    <h3>{{ Auth::user()->CalculateNonTripExpenseAmountTotal('',date('m'),date('Y')) }}</h3>--}}
                                    <h3>0</h3>
                                </div>
                                <div class="icon"><i class="ion ion-pie-graph"></i></div>
                                <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection