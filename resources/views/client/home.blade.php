@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-body">
                    <div class="col-sm-4">
                        <label>Month</label>
                        <select class="form-control dashboardDate" name="month" id="month" >
                            <option value="1" {{ (date("m")==1)?'selected':'' }}>January</option>
                            <option value="2" {{ (date("m")==2)?'selected':'' }}>February</option>
                            <option value="3" {{ (date("m")==3)?'selected':'' }}>March</option>
                            <option value="4" {{ (date("m")==4)?'selected':'' }}>April</option>
                            <option value="5" {{ (date("m")==5)?'selected':'' }}>May</option>
                            <option value="6" {{ (date("m")==6)?'selected':'' }}>June</option>
                            <option value="7" {{ (date("m")==7)?'selected':'' }}>July</option>
                            <option value="8" {{ (date("m")==8)?'selected':'' }}>August</option>
                            <option value="9" {{ (date("m")==9)?'selected':'' }}>September</option>
                            <option value="10" {{ (date("m")==10)?'selected':'' }}>October</option>
                            <option value="11" {{ (date("m")==11)?'selected':'' }}>November</option>
                            <option value="12" {{ (date("m")==12)?'selected':'' }}>December</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label>Year</label>
                        <select class="form-control dashboardDate" name="year" id="year">
                            <option value="{{ date("Y") }}">{{ date("Y") }}</option>
                            <option value="{{ date("Y") -1 }}">{{ date("Y") -1 }}</option>
                        </select>
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
                <a href="{{ route('client.DashboardVehicleExpenseTotal',[date('m'),date('Y')]) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <script src="//canvasjs.com/assets/script/canvasjs.min.js"></script>
        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div id="chartContainer" style="height: 400px; width: 100%;"></div>
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


    <script type="text/javascript">
        $(".dashboardDate").change(function() {
            var month =$('#month').val();
            var year =$('#year').val();
            $.ajax({
                type : "get",
                url : '/client/dashboard/total-income-expense',
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
                titleFontColor: "brown",
                lineColor: "#4F81BC",
                labelFontColor: "#4F81BC",
                tickColor: "#4F81BC"
            },
            toolTip: {
                shared: true
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