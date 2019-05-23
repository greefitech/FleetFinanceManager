@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add Expense Type</center>
                    </h4>
                    <a href="{{ route('client.ViewExpenseTypes') }}" class="btn btn-info pull-right">View Expense Type</a>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.SaveExpenseType') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('expenseType') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Expense Type</label>
                                            <input type="text" class="form-control" value="{{ old('expenseType') }}" placeholder="Enter Expense Type" name="expenseType">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Expense Type</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection