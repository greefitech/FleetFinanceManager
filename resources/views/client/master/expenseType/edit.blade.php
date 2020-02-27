@extends('client.layout.master')

@section('MasterMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Edit Expense / Income Type</center>
                    </h4>
                    <a href="{{ route('client.ViewExpenseTypes') }}" class="btn btn-info pull-right">View Expense/Income Type</a>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.UpdateExpenseType',$ExpenseType->id) }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('expenseType') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Expense Type</label>
                                            <input type="text" class="form-control" value="{{ $ExpenseType->expenseType }}" placeholder="Enter Expense Type" name="expenseType">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Update Expense Type</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection