@extends('client.layout.master')

@section('MasterMenu','active')

@section('content')

    <?php
        $IncomeDatas = unserialize($FinancialIndicator->income);
        $ExpenseDatas = unserialize($FinancialIndicator->expense);
    ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>{{ $Vehicle->vehicleNumber }} View Financial Indicator</center>
                        <a href="{{ route('client.EditFinancialIndicators',$FinancialIndicator->id) }}" class="btn btn-info btn-sm pull-right">Edit</a>
                    </h4>
                </div>

                <div class="box-body">

                    <div class="box-body">

                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div id="VehicleDetails" hidden>
                                    <h1 style="text-align: center;">{{ auth()->user()->transportName }} , {{ auth()->user()->address }}</h1>
                                    <p  style="text-align: center;">Mobile : {{ auth()->user()->mobile }}</p>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="color: blue;">Owner Name</th>
                                            <th style="color: blue;">Vehicle Number</th>
                                            <th style="color: blue;">Model Number</th>
                                            <th style="color: blue;">Engine Number</th>
                                            <th style="color: blue;">Chass Number</th>
                                        </tr>
                                        <tr>
                                            <th style="color: blue;">{{ $Vehicle->ownerName }}</th>
                                            <th style="color: blue;">{{ $Vehicle->vehicleNumber }}</th>
                                            <th style="color: blue;">{{ $Vehicle->modelNumber }}</th>
                                            <th style="color: blue;">-</th>
                                            <th style="color: blue;">-</th>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                </div>
                                <div class="panel-heading"><button type="button" onclick="printDiv('printableArea')" class="btn btn-info btn-sm pull-right">Print</button></div>
                                    <div class="panel-body" id="printableArea">
                                        @if(!empty($ExpenseDatas))
                                            @foreach($ExpenseDatas as $ExpenseDataKey=>$ExpenseData)
                                                <h4>{{ $ExpenseDatas[$ExpenseDataKey]['master_expense'] }} - Rs : <span style="color: green;">{{ array_sum($ExpenseDatas[$ExpenseDataKey]['amount']) }}</span>/-</h4>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Expense</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(isset($ExpenseDatas[$ExpenseDataKey]['date']))
                                                            @foreach($ExpenseDatas[$ExpenseDataKey]['date'] as $ExpenseInputKey=>$ExpenseInputs)
                                                                <tr>
                                                                    <td>{{ $ExpenseDatas[$ExpenseDataKey]['date'][$ExpenseInputKey] }}</td>
                                                                    <td>{{ $ExpenseDatas[$ExpenseDataKey]['expense'][$ExpenseInputKey] }}</td>
                                                                    <td>{{ $ExpenseDatas[$ExpenseDataKey]['amount'][$ExpenseInputKey] }}</td>
                                                                    <input class="form-control ExpenseValue" value="{{ $ExpenseDatas[$ExpenseDataKey]['amount'][$ExpenseInputKey] }}" hidden>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            @endforeach
                                        @endif
                                            <hr>
                                            <h3>Income</h3>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Expense</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(!empty($IncomeDatas))
                                                        @foreach($IncomeDatas['date'] as $IncomeKey=>$IncomeData)
                                                            <tr>
                                                                <td>{{ $IncomeDatas['date'][$IncomeKey] }}</td>
                                                                <td>{{ $IncomeDatas['income'][$IncomeKey] }}</td>
                                                                <td>{{ $IncomeDatas['amount'][$IncomeKey] }}</td>
                                                                <input class="form-control IncomeValue" value="{{ $IncomeDatas['amount'][$IncomeKey] }}" hidden>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                            <div class="row">
                                                <div class="col-lg-3 col-xs-6">
                                                    <div class="small-box bg-aqua">
                                                        <div class="inner">
                                                            <p>Expense</p>
                                                            <h3 class="TotalExpense"></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-xs-6">
                                                    <div class="small-box bg-aqua">
                                                        <div class="inner">
                                                            <p>Income</p>
                                                            <h3 class="TotalIncome"></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-xs-6">
                                                    <div class="small-box bg-aqua">
                                                        <div class="inner">
                                                            <p>Inversement</p>
                                                            <h3 class="Inversement"></h3>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')

    <style>
        .header {
            position: fixed;
            top: 0;
        }
        .footer {
            position: fixed;
            bottom: 0;
        }
    </style>

    <script type="text/javascript">
        function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var VehicleDetails = $('#VehicleDetails').html();
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = "<html><head><title></title></head><body>" + VehicleDetails + printContents + "</body>";
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>

    <script>
        // function printDiv(divName) {
        //     var printContents = document.getElementById(divName).innerHTML;
        //     var originalContents = document.body.innerHTML;
        //
        //     document.body.innerHTML = printContents;
        //
        //     window.print();
        //
        //     document.body.innerHTML = originalContents;
        // }

        function calculateIncomeExpense() {
            var Expense = 0;
            $('.ExpenseValue').each(function(){
                Expense += parseFloat($(this).val());
            });
            $('.TotalExpense').html(Expense);

            var Income = 0;
            $('.IncomeValue').each(function(){
                Income += parseFloat($(this).val());
            });
            $('.TotalIncome').html(Income);
            $('.Inversement').html(parseFloat(Expense) - parseFloat(Income));
        }
        calculateIncomeExpense();
    </script>
@endsection
