@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Category</center>
                    </h4>
                    <a href="{{ action('ClientController\Auditor\ExpenseCategoryGroupController@create') }}" class="btn btn-info pull-right">Create Expense Category</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$AuditorExpenseCategories->isEmpty())
                            <table  class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Expense List</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($AuditorExpenseCategories as $AuditorExpenseCategory)
                                    <tr>
                                        <td>{{ $AuditorExpenseCategory->category }} </td>
                                        <td>
                                            @foreach($AuditorExpenseCategory->AuditorExpenseTypes as $key=>$AuditorExpense)
                                                @if($key !=0) , @endif
                                                {{ $AuditorExpense->ExpenseTypes->expenseType }}
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ action('ClientController\Auditor\ExpenseCategoryGroupController@edit',$AuditorExpenseCategory->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @else
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
