@extends('client.layout.master')

@section('DashboardMenu','active')

@section('content')

@php
    $TripDetails = App\Trip::where('clientid',auth()->user()->id)->orderby('dateFrom')->first();
    // $ExpenseDetails = App\Expense::findorfail('185ef6a0-807b-11ea-a874-3ba7b3fe45c4');

@endphp

{{-- <marquee behavior="scroll"  direction="left">{!! stringReplaceScroll($ExpenseDetails->discription) !!}</marquee> --}}
<marquee behavior="scroll" scrollamount="4" direction="left"><li>Welcome <i>{{ auth()->user()->transportName }}</i> Your Service Expire on {{ date("d-m-Y", strtotime(auth()->user()->expires_on)) }}.Contact Admin</li></marquee>

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
        
        <!-- ./col -->
        <div class="col-lg-3 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-blue" id="DashboardIncome">
                <div class="inner">
                    <p>{{ date('M-Y') }} Income</p>
                    <h3>₹ 0</h3>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('client.DashboardVehicleProfitTotal',[date('m'),date('Y')]) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-12">
            <div class="small-box bg-red" id="DashboardExpense">
                <div class="inner">
                    <p>{{ date('M-Y') }} Expense</p>
                    <h3>₹ 0</h3>
                </div>
                <div class="icon"><i class="ion ion-pie-graph"></i></div>
                <a href="{{ route('client.DashboardVehicleProfitTotal',[date('m'),date('Y')]) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-green" id="DashboardProfit">
                <div class="inner">
                    <p>{{ date('M-Y') }} Profit</p>
                    <h3>₹ 0</h3>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('client.DashboardVehicleProfitTotal',[date('m'),date('Y')]) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-12">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <p>Out Standing Amount</p>
                    <h3>₹ {{ number_format(auth()->user()->get_outstanding_amount()) }}</h3>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('client.IncomeBalanceCustomerList') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        {{-- graph --}}
        <div class="col-sm-9 col-lg-9 col-xs-12">
            <div id="Main_Graph" class="chart"></div>
        </div>
        {{-- start of pending amount --}}
        <div class="col-lg-3 col-xs-12">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <p>In Pending Amount</p>
                    <h3>₹ {{ nonTripUnpaidExpneseTotal(auth()->user()->id) }}</h3>
                </div>
                <div class="icon">
                    <i class="ion ion-compass"></i>
                </div>
                <a href="{{ action('ClientController\DashboardController@unPaidExpenseList') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>

            {{-- Documet renewal on same panel --}}
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h5 class="box-title">Document Renewal</h5>
                        </div>
                        <div class="box-body">
                        </div>
                    </div>
                </div>
            </div>

            {{-- end --}}
        </div>
        {{-- end of in pending amount --}}
        
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
            if(MonthYear !=''){
                $.ajax({
                    type : "get",
                    url : '/client/dashboard/total-income-expense',
                    data:{MonthYear:MonthYear},
                    beforeSend: function() {
                        $('#DashboardIncome').find('h3').html('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                        $('#DashboardExpense').find('h3').html('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                        $('#DashboardProfit').find('h3').html('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                    success:function(data){
                        setTimeout(function() {
                            $('#DashboardIncome').html(data.Income);
                            $('#DashboardExpense').html(data.expense);
                            $('#DashboardProfit').html(data.Profit);
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
        }
    </script>

    <script type="text/javascript">

        // $(window).resize(function(){
        //     drawChart();
        // });

  </script>

@endsection
