@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Expense Type</center>
                    </h4>
                    <a href="{{ route('admin.AddExpense') }}" class="btn btn-info pull-right">Add Expense Type</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty($ExpenseTypes))
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                <tr>
                                    <th style="text-align:center">Expense Type</th>
                                    <th style="text-align:center">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($ExpenseTypes as $key=>$ExpenseType)
                                    <tr>
                                        <td>{{ $ExpenseType->expenseType }}</td>
                                        <td style="text-align:center">
                                            <a href="{{ route('admin.ExpenseTypeEdit',$ExpenseType->id) }}"><button type="button" class="btn btn-success">Edit</button></a>
                                            @if($ExpenseType->id!=1 && $ExpenseType->id!=2)
                                                <a href="{{ route('admin.deleteExpenseType',$ExpenseType->id) }}"><button type="button" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                        @else
                            <blockquote><p>Expense Type Didn't added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection