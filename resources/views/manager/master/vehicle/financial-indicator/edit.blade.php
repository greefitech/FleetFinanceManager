@extends('manager.layout.master')

@section('content')

    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Expense</span>
                    <span class="info-box-number TotalExpense"></span>
                </div>
            </div>
        </div>

        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Income</span>
                    <span class="info-box-number TotalIncome"></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Investment</span>
                    <span class="info-box-number Inversement"></span>
                </div>
            </div>
        </div>
    </div>

    <?php
        $IncomeDatas = unserialize($FinancialIndicator->income);
        $ExpenseDatas = unserialize($FinancialIndicator->expense);

    ?>


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>{{ $Vehicle->vehicleNumber }} Edit Financial Indicator</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('manager.UpdateFinancialIndicators',[$Vehicle->id,$FinancialIndicator->id]) }}">
                        {{ csrf_field() }}
                        <div class="box-body">

                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Expense</div>
                                    <div class="panel-body AddExpenseModuleDiv">

                                    @if(!empty($ExpenseDatas))
                                        @foreach($ExpenseDatas as $ExpenseDataKey=>$ExpenseData)
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <button type="button" class="btn btn-danger btn-sm pull-right RemoveModule"><i class="fa fa-close"></i></button>
                                                <div class="row">
                                                    <div class="form-group{{ $errors->has('ExpenseData.'.$ExpenseDataKey.'.master_expense') ? ' has-error' : '' }}">
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" placeholder="Enter Master Expense" value="{{ $ExpenseDatas[$ExpenseDataKey]['master_expense'] }}" name="ExpenseData[{{$ExpenseDataKey }}][master_expense]">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="AddExpenseInputDiv{{$ExpenseDataKey}}">
                                                @if(isset($ExpenseDatas[$ExpenseDataKey]['date']))
                                                    @foreach($ExpenseDatas[$ExpenseDataKey]['date'] as $ExpenseInputKey=>$ExpenseInputs)
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <div class="form-group{{ $errors->has('ExpenseData.'.$ExpenseDataKey.'.date.'.$ExpenseInputKey) ? ' has-error' : '' }}">
                                                                    <div class="col-sm-12">
                                                                        <label>Date</label>
                                                                        <input type="date" class="form-control" placeholder="Enter Master Expense" value="{{ $ExpenseDatas[$ExpenseDataKey]['date'][$ExpenseInputKey] }}" name="ExpenseData[{{$ExpenseDataKey}}][date][]">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group{{ $errors->has('ExpenseData.'.$ExpenseDataKey.'.expense.'.$ExpenseInputKey) ? ' has-error' : '' }}">
                                                                    <div class="col-sm-12">
                                                                        <label>Expense</label>
                                                                        <input type="text" class="form-control" placeholder="Enter Master Expense" value="{{ $ExpenseDatas[$ExpenseDataKey]['expense'][$ExpenseInputKey] }}" name="ExpenseData[{{$ExpenseDataKey}}][expense][]">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group{{ $errors->has('ExpenseData.'.$ExpenseDataKey.'.amount.'.$ExpenseInputKey) ? ' has-error' : '' }}">
                                                                    <div class="col-sm-12">
                                                                        <label>Amount</label>
                                                                        <input type="number" min="0" class="form-control ExpenseValue" placeholder="Enter Expense Amount" value="{{ $ExpenseDatas[$ExpenseDataKey]['amount'][$ExpenseInputKey] }}" name="ExpenseData[{{$ExpenseDataKey}}][amount][]">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <button type="button" class="btn btn-danger btn-sm pull-right RemoveModule"><i class="fa fa-close"></i></button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                </div>
                                                <button type="button" buttonId="{{$ExpenseDataKey}}" class="btn btn-success btn-sm pull-left AddExpenseInput">+</button>
                                            </div>
                                        </div>
                                            @endforeach
                                    @endif


                                    </div>
                                </div>
                            </div>

                            <div class="panel-group">
                                <div class="panel panel-success">
                                    <div class="panel-heading">Income</div>
                                    <div class="panel-body AddInputModuleDiv">


                                    @if(!empty($IncomeDatas))
                                        @foreach($IncomeDatas['date'] as $IncomeKey=>$IncomeData)
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group{{ $errors->has('IncomeData.date.'.$IncomeKey) ? ' has-error' : '' }}">
                                                        <div class="col-sm-12">
                                                            <label>Date</label>
                                                            <input type="date" class="form-control" placeholder="Enter Master Expense" value="{{ $IncomeDatas['date'][$IncomeKey] }}" name="IncomeData[date][]">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group{{ $errors->has('IncomeData.income.'.$IncomeKey) ? ' has-error' : '' }}">
                                                        <div class="col-sm-12">
                                                            <label>Income</label>
                                                            <input type="text" class="form-control" placeholder="Enter Master Expense" value="{{ $IncomeDatas['income'][$IncomeKey] }}" name="IncomeData[income][]">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group{{ $errors->has('IncomeData.amount.'.$IncomeKey) ? ' has-error' : '' }}">
                                                        <div class="col-sm-12">
                                                            <label>Amount</label>
                                                            <input type="number" min="0" class="form-control IncomeValue" placeholder="Enter Amount" value="{{ $IncomeDatas['amount'][$IncomeKey] }}" name="IncomeData[amount][]">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-1">
                                                    <button type="button" class="btn btn-danger btn-sm pull-right RemoveModule"><i class="fa fa-close"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif




                                    </div>
                                </div>
                            </div>

                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Update Financial Indicator</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <button type="button" class="btn btn-primary btn-sm AddExpenseModule" style="margin: 0;position: fixed;bottom: 7%;right: 1%;z-index: 100;text-decoration: none;">Add Expense</button>
    <button type="button" class="btn btn-success btn-sm AddIncomeModule" style="margin: 0;position: fixed;bottom: 7%;right: 8%;z-index: 100;text-decoration: none;">Add Income</button>
@endsection

@section('script')
    <script>
        $('.AddInputModuleDiv').sortable();
        $('.AddExpenseModuleDiv').sortable();
        var ExpenseI = {{ (isset($ExpenseDataKey))?++$ExpenseDataKey:0 }};
        $('body').on('click','.RemoveModule',function (e) {
            e.preventDefault();
            $(this).parent().parent().remove();
        });
        $(document).ready(function() {
            $('body').on('click','.AddExpenseModule',function (e) {
                e.preventDefault();
                var ExpenseData=
                '<div class="panel panel-primary">\n' +
                '    <div class="panel-heading">\n' +
                '        <button type="button" class="btn btn-danger btn-sm pull-right RemoveModule"><i class="fa fa-close"></i></button>\n' +
                '        <div class="row">\n' +
                '            <div class="col-sm-4">\n' +
                '                <input type="text" class="form-control" placeholder="Enter Master Expense" name="ExpenseData[' + ExpenseI + '][master_expense]">\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '    <div class="panel-body">\n' +
                '        <div class="AddExpenseInputDiv'+ExpenseI+'">\n' +
                '        </div>\n' +
                '        <button type="button" buttonId="'+ExpenseI+'" class="btn btn-success btn-sm pull-left AddExpenseInput">+</button>\n' +
                '    </div>\n' +
                '</div>';
                ExpenseI++;
                $('.AddExpenseModuleDiv').append(ExpenseData);
            });


            $('body').on('click','.AddExpenseInput',function (e) {
                e.preventDefault();
                var ExpenseInput =
                    '<div class="row">\n' +
                    '    <div class="col-sm-3">\n' +
                    '        <div class="form-group">\n' +
                    '            <div class="col-sm-12">\n' +
                    '                <label>Date</label>\n' +
                    '                <input type="date" class="form-control" placeholder="Enter Master Expense" name="ExpenseData[' + $(this).attr('buttonId') + '][date][]">\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '    <div class="col-sm-4">\n' +
                    '        <div class="form-group">\n' +
                    '            <div class="col-sm-12">\n' +
                    '                <label>Expense</label>\n' +
                    '                <input type="text" class="form-control" placeholder="Enter Master Expense" name="ExpenseData[' + $(this).attr('buttonId') + '][expense][]">\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '    <div class="col-sm-4">\n' +
                    '        <div class="form-group">\n' +
                    '            <div class="col-sm-12">\n' +
                    '                <label>Amount</label>\n' +
                    '                <input type="number" min="0" class="form-control ExpenseValue" placeholder="Enter Expense Amount" name="ExpenseData[' + $(this).attr('buttonId') + '][amount][]">\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '    <div class="col-sm-1">\n' +
                    '        <button type="button" class="btn btn-danger btn-sm pull-right RemoveModule"><i class="fa fa-close"></i></button>\n' +
                    '    </div>\n' +
                    '</div>';
                $('.AddExpenseInputDiv'+$(this).attr('buttonId')).append(ExpenseInput);
            });

            $('body').on('click','.AddIncomeModule',function (e) {
                e.preventDefault();
                var InputData =
                    ' <div class="row">\n' +
                    '    <div class="col-sm-3">\n' +
                    '        <div class="form-group">\n' +
                    '            <div class="col-sm-12">\n' +
                    '                <label>Date</label>\n' +
                    '                <input type="date" class="form-control" placeholder="Enter Master Expense" name="IncomeData[date][]">\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '    <div class="col-sm-4">\n' +
                    '        <div class="form-group">\n' +
                    '            <div class="col-sm-12">\n' +
                    '                <label>Income</label>\n' +
                    '                <input type="text" class="form-control" placeholder="Enter Master Expense" name="IncomeData[income][]">\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '    <div class="col-sm-4">\n' +
                    '        <div class="form-group">\n' +
                    '            <div class="col-sm-12">\n' +
                    '                <label>Amount</label>\n' +
                    '                <input type="number" min="0" class="form-control IncomeValue" placeholder="Enter Amount" name="IncomeData[amount][]">\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '    <div class="col-sm-1">\n' +
                    '        <button type="button" class="btn btn-danger btn-sm pull-right RemoveModule"><i class="fa fa-close"></i></button>\n' +
                    '    </div>\n' +
                    '</div>';
                $('.AddInputModuleDiv').append(InputData);
            });
        });







        $('body').on('keyup change','.ExpenseValue',function (e) {
            e.preventDefault();
            calculateIncomeExpense();
        });

        $('body').on('keyup change','.IncomeValue',function (e) {
            e.preventDefault();
            calculateIncomeExpense();
        });

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