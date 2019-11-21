@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Report</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.DownloadExpenseReport') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('dateFrom') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Date From</label>
                                            <input type="date" class="form-control" value="{{ old('dateFrom') }}" placeholder="Enter Date" name="dateFrom"  id="entry-dateFrom">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('dateTo') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Date To</label>
                                            <input type="date" class="form-control" value="{{ old('dateTo') }}" placeholder="Enter Date To" name="dateTo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle</label>
                                            <select name="vehicleId" class="form-control select2" id="entry-vehicle">
                                                <option value="">Select Vehicle</option>
                                                @foreach(Auth::user()->vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}" {{ ($vehicle->id == old('vehicleId'))?'selected':'' }}>{{ $vehicle->vehicleNumber }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group{{ $errors->has('expense_type') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Expense</label>
                                            <select name="expense_type[]" class="form-control" multiple id="entry-type">
                                                @foreach($ExpenseTypes as $ExpenseType)
                                                    <option value="{{ $ExpenseType->id }}" {{ !empty(old('expense_type'))? in_array($ExpenseType->id,old('expense_type')) ? 'selected' : '' : '' }}>{{ $ExpenseType->expenseType }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('report_wise') ? ' has-error' : '' }}">
                                    <label>Report Wise</label>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="report_wise[]" class="form-check-input" value="expense" {{ !empty(old('report_wise'))? in_array('expense',old('report_wise')) ? 'checked' : '' : '' }}>&nbsp;&nbsp;Expense
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="form-check-label">
                                                <input type="checkbox" name="report_wise[]" class="form-check-input" value="income" {{ !empty(old('report_wise'))?in_array('income',old('report_wise')) ? 'checked' : '' : '' }}>&nbsp;&nbsp;Income
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="form-check-label">
                                                <input type="checkbox" name="report_wise[]" class="form-check-input" value="non_trip_expense" {{ !empty(old('report_wise'))?in_array('non_trip_expense',old('report_wise')) ? 'checked' : '' : '' }}>&nbsp;&nbsp;Non-Trip Expense
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="form-check-label">
                                                <input type="checkbox" name="report_wise[]" class="form-check-input" value="extra_income" {{ !empty(old('report_wise'))?in_array('extra_income',old('report_wise')) ? 'checked' : '' : '' }}>&nbsp;&nbsp;Extra Income
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Download Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection