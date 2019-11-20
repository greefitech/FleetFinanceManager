@extends('client.layout.master')

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
                    <h3>{{ auth()->user()->CalculateProfitAmountTotal('',date('m'),date('Y')) }}</h3>
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
                    <h3>{{ Auth::user()->CalculateNonTripExpenseAmountTotal('',date('m'),date('Y')) }}</h3>
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

    
    <?php
    $income = array();
    $Expense = array();
    $years = array(date('Y')-1,date('Y'));
    foreach ($years as $year){
        for ($i=1;$i<=12;$i++){
            $incomeData = auth()->user()->CalculateProfitAmountTotal('',$i,$year);
            array_push($income,$incomeData);
            $ExpenseData = auth()->user()->CalculateNonTripExpenseAmountTotal('',$i,$year);
            array_push($Expense,$ExpenseData);
        }
    }
    ?>
@endsection


@section('script')

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        $(".dashboardDate").change(function() {
            var MonthYear =$('.dashboardDate').val();
            $.ajax({
                type : "get",
                url : '/client/dashboard/total-income-expense',
                data:{MonthYear:MonthYear},
                success:function(data){
                    $('#DashboardIncome').html(data.Income);
                    $('#DashboardExpense').html(data.expense);
                }
            });
        });
    </script>

    <script type="text/javascript">

        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
          var data = google.visualization.arrayToDataTable([
            ['Month', 'Sales', 'Expenses'],
            @php
                $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                $month = 1;
                for($i=0;$i<12;$i++){
                    $ProfitAmount =  auth()->user()->CalculateProfitAmountTotal('',$month,date('Y'));
                    $ExpenseAmount =  auth()->user()->CalculateNonTripExpenseAmountTotal('',$month,date('Y'));
                    echo '["'.$monthNames[$i].'",'.$ProfitAmount.','.$ExpenseAmount.'],';
                    $month++;
                }  
            @endphp
            ]);

          var options = {
            title: 'Company Performance',
            hAxis: {title: 'Month', titleTextStyle: {color: 'Black'}},
            
         };

        var chart = new google.visualization.ColumnChart(document.getElementById('Main_Graph'));
          chart.draw(data, options);
        }

        $(window).resize(function(){
            drawChart();
        });

  </script>

@endsection
