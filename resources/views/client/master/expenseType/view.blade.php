@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Expense / Income Types</center>
                    </h4>
                    <a href="{{ route('client.AddExpenseType') }}" class="btn btn-info pull-right">Add Type</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$ExpenseTypes->isEmpty())
                            <table  class="table table-bordered table-striped DataTable table-hover">
                                <thead>
                                    <tr>
                                        <th>Expense / Income Type</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ExpenseTypes as $ExpenseType)
                                        <tr>
                                            <td>{{ $ExpenseType->expenseType }}</td>
                                            <td>{{ (!empty($ExpenseType->managerid))?$ExpenseType->manager->name:auth()->user()->name }}</td>
                                            <td>
                                                <form action="{{ route('client.DeleteExpenseType',$ExpenseType->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a href="{{ route('client.EditExpenseType',$ExpenseType->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                                    <button href="" onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>
                                                </form>
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