@extends('client.layout.master')

@section('DashboardMenu','active')

@section('content')

@php
    $TripDetails = App\Trip::where('clientid',auth()->user()->id)->orderby('dateFrom')->first();
@endphp

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-body">
                    <div class="col-sm-4">
                        <label>Year</label>
                        @if(!empty($TripDetails))
	                        <input type="month" class="form-control dashboardDate" min="{{ date("Y-m", strtotime($TripDetails->dateFrom)) }}" max="{{ date('Y-m') }}" value="{{ date('Y-m') }}">
                        @else
	                        <input type="month" class="form-control dashboardDate" min="{{ date('Y-m') }}" max="{{ date('Y-m') }}" value="{{ date('Y-m') }}">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-xs-12">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <p>Out Standing Amount</p>
                    <h3>{{ auth()->user()->get_outstanding_amount() }}</h3>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('client.IncomeBalanceCustomerList') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-green" id="DashboardIncome">
                <div class="inner">
                    <p>{{ date('M-Y') }} Profit</p>
                    <h3>0</h3>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('client.DashboardVehicleProfitTotal',[date('m'),date('Y')]) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-12">
            <div class="small-box bg-red" id="DashboardExpense">
                <div class="inner">
                    <p>{{ date('M-Y') }} Expense</p>
                    <h3>0</h3>
                </div>
                <div class="icon"><i class="ion ion-pie-graph"></i></div>
                <a href="{{ route('client.DashboardVehicleProfitTotal',[date('m'),date('Y')]) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <style>
        .chart {
            width: 100%; 
            min-height: 450px;
        }
        .row {
            margin:0 !important;
        }
    </style>

    <div class="row">
        <script src="//canvasjs.com/assets/script/canvasjs.min.js"></script>
        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div id="columnchart_material"></div>
        </div>

        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div id="Main_Graph" class="chart"></div>
        </div>
    </div>

@endsection


@section('script')

    <script type="text/javascript">
            DashboardChart('');
        $(".dashboardDate").on('focus', function () {
           var OldDate = $(this);
            OldDate.data('previous', OldDate.val());
        }).change(function() {
            var OldDate = $(this);
            DashboardChart(OldDate.data('previous'));
        });

        function DashboardChart(OldDate) {
            var MonthYear =$('.dashboardDate').val();
            $.ajax({
                type : "get",
                url : '/client/dashboard/total-income-expense',
                data:{MonthYear:MonthYear},
                beforeSend: function() {
                    $('#DashboardIncome').find('h3').html('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    $('#DashboardExpense').find('h3').html('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success:function(data){
                    setTimeout(function() {
                        $('#DashboardIncome').html(data.Income);
                        $('#DashboardExpense').html(data.expense);
                        if(OldDate == '' || OldDate.split("-")[0] != MonthYear.split("-")[0]){
                            $.ajax({
                                url: 'https://www.google.com/jsapi?callback',
                                cache: true,
                                dataType: 'script',
                                success: function(data){
                                    google.load('visualization', '1', {packages:['corechart'], 'callback' : function(){
                                        $.ajax({
                                            type: "get",
                                            dataType: "json",
                                            data:{MonthYear:MonthYear},
                                            url: '{{ action("ClientController\DashboardController@DashboardGetChartValues") }}',
                                            success: function(jsondata) {
                                                var data = google.visualization.arrayToDataTable(jsondata.data);
                                                var options = {title: 'Income Expense '+jsondata.year};
                                                var chart = new google.visualization.ColumnChart(document.getElementById('Main_Graph'));
                                                chart.draw(data, options);
                                            }
                                        }); 
                                    }});
                                }
                            });
                        }
                        
                    }, 1000);
                }
            });
        }
    </script>

    <script type="text/javascript">

        // $(window).resize(function(){
        //     drawChart();
        // });

  </script>

@endsection
