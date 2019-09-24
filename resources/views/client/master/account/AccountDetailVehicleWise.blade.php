@extends('client.layout.master')

@section('content')



 <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                	<h4>                         
                        <a href="{{ route('client.ViewAccounts') }}"><button class="btn btn-info pull-right">View Accounts</button></a>

                    </h4>
                    <h4>
                        <center>View Vehicle Expense Detail</center>
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
                                            <td>{{ $Expense->date }}</td>
                                            <td>{{ $Expense->ExpenseType->expenseType }}</td>
                                            <td></td>
                                            <td style="color: red;">{{ $Expense->amount }}</td>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @foreach($Entries as $Entry)
                                        <tr>
                                            <td>{{ $Entry->dateFrom }}</td>
                                            <td>Advance Amount</td>
                                            <td>{{ $Entry->advance }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                    @foreach($ExtraIncomes as $ExtraIncome)
                                        <tr>
                                            <td>{{ $ExtraIncome->date }}</td>
                                            <td>{{ $ExtraIncome->ExpenseType->expenseType }}</td>
                                            <td>{{ $ExtraIncome->amount }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                    @foreach($Incomes as $Income)
                                        <tr>
                                            <td>{{ $Income->date }}</td>
                                            <td>Receving Amount</td>
                                            <td>{{ $Income->recevingAmount }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Vehicle till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection