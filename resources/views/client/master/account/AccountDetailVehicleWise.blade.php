@extends('client.layout.master')

@section('MasterMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                	<h4>                         
                        <a href="{{ route('client.ViewAccounts') }}"><button class="btn btn-info pull-right">View Accounts</button></a>
                        <center>{{ $Account->account }} {{ $Vehicle->vehicleNumber }} Detail</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!auth()->user()->Accounts->isEmpty())
                            <table  class="table table-bordered table-striped DataTable table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Expense / Inocme</th>
                                        <th>Credit</th>
                                        <th>Debit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Expenses as $Expense)
                                        <tr>
                                            <td>{{ date("d-m-Y", strtotime($Expense->date)) }}</td>
                                            <td>{{ $Expense->ExpenseType->expenseType }}</td>
                                            <td style="color: green;"></td>
                                            <td style="color: red;">{{ $Expense->amount }}</td>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @foreach($Entries as $Entry)
                                        <tr>
                                            <td>{{ date("d-m-Y", strtotime($Entry->dateFrom)) }}</td>
                                            <td>Advance Amount</td>
                                            <td>{{ $Entry->advance }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                    @foreach($ExtraIncomes as $ExtraIncome)
                                        <tr>
                                            <td>{{ date("d-m-Y", strtotime($ExtraIncome->date)) }}</td>
                                            <td>{{ $ExtraIncome->ExpenseType->expenseType }}</td>
                                            <td>{{ $ExtraIncome->amount }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                    @foreach($Incomes as $Income)
                                        <tr>
                                            <td>{{ date("d-m-Y", strtotime($Income->date)) }}</td>
                                            <td>Receving Amount</td>
                                            <td style="color: green;">{{ $Income->recevingAmount }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Account till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection