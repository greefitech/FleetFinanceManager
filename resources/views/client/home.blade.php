@extends('client.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <p>Out Standing Amount</p>
                    <h3>{{ auth()->user()->get_outstanding_amount() }}</h3>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <p>{{ date('M-Y') }} Profit</p>
                    <h3>{{ auth()->user()->get_profit_amount(date('m'),date('Y')) }}</h3>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <p>{{ date('M-Y') }} Expense</p>
                    <h3>{{ Auth::user()->get_non_trip_expense(date('m'),date('Y')) }}</h3>
                </div>
                <div class="icon"><i class="ion ion-pie-graph"></i></div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
            <div id="chartContainer" ></div>
        </div>
    </div>

    <?php
    $income = array();
    $Expense = array();
    $years = array(date('Y')-1,date('Y'));
    foreach ($years as $year){
        for ($i=1;$i<=12;$i++){
            $incomeData = auth()->user()->get_profit_amount($i,$year);
            array_push($income,$incomeData);
            $ExpenseData = auth()->user()->get_non_trip_expense($i,$year);
            array_push($Expense,$ExpenseData);
        }
    }
    ?>
@endsection


@section('script')

    <script type="text/javascript">
        $(".dashboardDate").change(function() {
            var month =$('#month').val();
            var year =$('#year').val();
            $.ajax({
                type : "get",
                url : '/client/getdashboardtotalincomeexpense',
                data:{month:month,year:year},
                success:function(data){
                    $('#DashboardIncome').html(data.Income);
                    $('#DashboardExpense').html(data.expense);
                }
            });
        });
        var income = [];
        var expense = [];
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title:{
                theme: "light2",
                text: "Income & Expense Jan <?php echo (date('Y')-1).' - Dec '.date('Y')  ?>"
            },
            axisX:{
                valueFormatString: "MMM Y"
            },

            axisY: {
                title: "Amount",
                valueFormatString: "0#",
                tickColor: "#00000",
            },

            data: [{
                type: "column",
                showInLegend: true,
                dataPoints: income,
                name: "Profit Amount",
            },{
                type: "column",
                showInLegend: true,
                dataPoints: expense,
                name: "Expense Amount",
            }]
        });
        var IncomeValue = [<?php echo ''.implode(',', $income).'' ?>];
        var ExpenseValue = [<?php echo ''.implode(',', $Expense).'' ?>];

        var i=0;
        IncomeValue.forEach(function(element) {
            income.push({
                x:new Date(<?php echo date('Y')-1 ?>,i),
                y:IncomeValue[i]
            });
            i++;
        });

        var i=0;
        ExpenseValue.forEach(function(element) {
            expense.push({
                x:new Date(<?php echo date('Y')-1 ?>,i),
                y:ExpenseValue[i]
            });
            i++;
        });
        chart.render();
    </script>
@endsection