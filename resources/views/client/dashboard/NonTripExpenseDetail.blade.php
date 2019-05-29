@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <center>
                <h4>{{ $Vehicle->vehicleNumber }} {{ date('F', mktime(0, 0, 0, $Month, 10)) }} {{ $Year }} Expense</h4>
                <h4><span style="color: green;font-size: 25px"><i class="fa fa-rupee"></i> {{ auth()->user()->CalculateNonTripExpenseAmountTotal($Vehicle->id,$Month,$Year) }}</span></h4>
            </center>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$Expenses->isEmpty())
                            <table  class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Income Type</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Expenses as $Expense)
                                        <tr>
                                            <td>{{ date("d-m-Y", strtotime($Expense->date)) }}</td>
                                            <td>{{ $Expense->ExpenseType->expenseType }}</td>
                                            <td>{{ $Expense->amount }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Expense till now!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection