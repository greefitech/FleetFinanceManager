@extends('client.layout.master')

@section('header')
    Dashboard
@endsection

@section('dashboard')
    is-active
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-2">
            <div class="c-field u-mb-medium">
                <label class="c-field__label" for="date-month">Month</label>
                <select class="c-input dashboardDate" name="month" id="month" >
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
        </div>
        <div class="col-lg-2">
            <div class="c-field u-mb-medium">
                <label class="c-field__label" for="date-year">Year</label>
                <select class="c-input dashboardDate" name="year" id="year">
                    <option value="{{ date("Y") }}">{{ date("Y") }}</option>
                    <option value="{{ date("Y") -1 }}">{{ date("Y") -1 }}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-4">
            <div class="c-card">
                <span class="c-icon c-icon--info u-mb-small">
                  <i class="feather icon-activity"></i>
                </span>
                <a href="{{url('/client/addincome')}}">
                    <h3 class="c-text--subtitle">Total Out Standing</h3>
                    <h1>{{ Auth::user()->get_outstanding_amount() }}</h1>
                </a>
            </div>
        </div>


        <div class="col-md-6 col-xl-4" id="DashboardIncome">
            <div class="c-card">
                <span class="c-icon c-icon--success u-mb-small">
                  <i class="feather icon-activity"></i>
                </span>
                <a href="{{url('/client/dashboard/vehicleWiseCurrentMonthProfit/'.date('m').'/'.date('Y'))}}">
                    <h3 class="c-text--subtitle">{{ date('M-Y') }} Profit</h3>
                    <h1>{{ auth()->user()->get_profit_amount(date('m'),date('Y')) }}</h1>
                </a>
            </div>
        </div>


        {{--<div class="col-md-6 col-xl-4">--}}
            {{--<div class="c-card">--}}
                {{--<span class="c-icon c-icon--success u-mb-small">--}}
                  {{--<i class="feather icon-activity"></i>--}}
                {{--</span>--}}
                {{--<a href="{{url('/client/dashboard/vehicleWiseCurrentMonthIncome')}}">--}}
                    {{--<h3 class="c-text--subtitle">{{ date('M-Y') }} Turnover</h3>--}}
                    {{--<h1>{{ Auth::user()->get_income_amount() }}</h1>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}

        <div class="col-md-6 col-xl-4" id="DashboardExpense">
            <div class="c-card">
                <span class="c-icon c-icon--danger u-mb-small">
                  <i class="feather icon-activity"></i>
                </span>
                <a href="{{url('/client/dashboard/vehicleWiseCurrentMonthExpense/'.date('m').'/'.date('Y'))}}">
                    <h3 class="c-text--subtitle">{{ date('M-Y') }} Expense</h3>
                    <h1>{{ Auth::user()->get_non_trip_expense(date('m'),date('Y')) }}</h1>
                </a>
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

@section('OnloadScript')
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