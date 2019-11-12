@extends('manager.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Expense Types</center>
                    </h4>
                    <a href="{{ route('manager.AddExpenseType') }}" class="btn btn-info pull-right">Add Expense Type</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$ExpenseTypes->isEmpty())
                            <table  class="table table-bordered table-striped DataTable table-hover">
                                <thead>
                                    <tr>
                                        <th>Expense Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ExpenseTypes as $ExpenseType)
                                        <tr>
                                            <td>{{ $ExpenseType->expenseType }}</td>
                                            <td>
                                                <a href="{{ route('manager.EditExpenseType',$ExpenseType->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Expense Type till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection