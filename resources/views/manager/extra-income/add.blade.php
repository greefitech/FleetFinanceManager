@extends('manager.layout.master')

@section('content')


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add Extra Income</center>
                    </h4>
                    <a href="{{ route('manager.ViewExtraIncomes') }}" class="btn btn-info pull-right">View Extra Income</a>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('manager.SaveExtraIncome') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Date</label>
                                            <input type="date" class="form-control" value="{{ old('date') }}" placeholder="Enter Date" name="date"  id="entry-dateFrom">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle</label>
                                            <select name="vehicleId" class="form-control select2" id="entry-vehicle">
                                                <option value="">Select Vehicle Type</option>
                                                @foreach(Auth::user()->vehicles() as $vehicle)
                                                    <option value="{{ $vehicle->id }}" {{ ($vehicle->id==old('vehicleId'))?'selected':'' }}>{{ $vehicle->vehicleNumber }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('expense_type') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Income Type</label>
                                            <select name="expense_type" class="form-control select2">
                                                <option value="">Select Income</option>
                                                @foreach($ExpenseTypes as $ExpenseType)
                                                    <option value="{{ $ExpenseType->id }}" {{ ($ExpenseType->id == old('type')) ? 'selected':'' }}>{{ $ExpenseType->expenseType }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Amount</label>
                                            <input type="number" class="form-control" value="{{ old('amount') }}" placeholder="Enter Amount" name="amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('account_id') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Payment Type</label>
                                            <select name="account_id" class="form-control">
                                                <option value="1">Cash</option>
                                                @foreach(Auth::user()->Accounts as $Account)
                                                    <option value="{{ $Account->id }}" {{ ($Account->id==old('account_id'))?'selected':'' }}>{{ $Account->account }} - {{ !empty($Account->HolderName)? $Account->HolderName:'' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Payment Status</label>
                                            <select class="form-control" name="status">
                                                <option value="1">Paid</option>
                                                <option value="0">Not Paid</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Description</label>
                                            <textarea class="form-control" name="description">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Extra Income</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection