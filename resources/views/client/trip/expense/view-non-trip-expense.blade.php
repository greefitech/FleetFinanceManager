@extends('client.layout.master')

@section('NonTripExpenseMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>{{ $Vehicle->vehicleNumber }} Expense List</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$Expenses->isEmpty())
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Expense Type</th>
                                        <th>Location</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Description</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Expenses as $Expense)
                                        <tr>
                                            <td>{{ date("d-m-Y", strtotime($Expense->date)) }}</td>
                                            <td>{{ $Expense->ExpenseType->expenseType }}</td>
                                            <td>{{ $Expense->location }}</td>
                                            <td>{{ $Expense->quantity }}</td>
                                            <td>{{ $Expense->amount }}</td>
                                            <td><span class="label label-{{ ($Expense->status == 0)?'danger':'success' }}">{{ ($Expense->status == 0)?'Not Paid':'Paid' }}</span></td>
                                            <td>{{ $Expense->discription }}</td>
                                            <td>--</td>
                                            <td>
                                                <form action="{{ route('client.DeleteExpense',$Expense->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a href="{{ action('ClientController\ExpenseController@EditNonTripExpense',$Expense->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                                    <button href="" onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Expense till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection