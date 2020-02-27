@extends('client.layout.master')

@section('EntryMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Edit Expense</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.UpdateExpense',$Expense->id) }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group{{ $errors->has('tripId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Trip</label>
                                            <select name="tripId" class="form-control select2"  id="entry-trip">
                                                @if($Trips->status ==0)
                                                   <option value="">Select Trip</option>
                                                    @foreach(Auth::user()->NotCompletedTrips as $Trip)
                                                        <option value="{{ $Trip->id }}" {{ ($Trip->id == $Expense->tripId)?'selected':'' }}>{{ $Trip->vehicle->vehicleNumber }} | {{ $Trip->tripName }} | {{ date("d-m-Y", strtotime($Trip->dateFrom)) }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="{{ $Trips->id }}">{{ $Trips->vehicle->vehicleNumber }} | {{ $Trips->tripName }} | {{ date("d-m-Y", strtotime($Trips->dateFrom)) }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Date</label>
                                            <input type="date" class="form-control" value="{{ $Expense->date }}" placeholder="Enter Date" name="date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle</label>
                                            <select name="vehicleId" class="form-control expense-vehicle LastExpense select2" id="entry-vehicle">
                                                <option value="">Select Vehicle</option>
                                                @foreach(Auth::user()->vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}" {{ ($vehicle->id==$Expense->vehicleId)?'selected':'' }}>{{ $vehicle->vehicleNumber }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('expense_type') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Expense</label>
                                            <select name="expense_type" class="form-control expense-type LastExpense select2" id="entry-type">
                                                <option value="">Select Expense Type</option>
                                                @foreach($ExpenseTypes as $ExpenseType)
                                                    <option value="{{ $ExpenseType->id }}" {{ ($ExpenseType->id == $Expense->expense_type)?'selected':'' }}>{{ $ExpenseType->expenseType }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 expense_staff_div">
                                    <div class="form-group{{ $errors->has('staffId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Staff</label>
                                            <select name="staffId" class="form-control" id="expense-staff">
                                                <option value="">Select Staff</option>
                                                @foreach(Auth::user()->staffs as $staff)
                                                    <option value="{{ $staff->id }}" {{ ($staff->id == $Expense->staffId) ? 'selected':'' }}>{{ $staff->name }} | {{ $staff->mobile1 }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 expense_quantity_div">
                                    <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Quantity</label>
                                            <input type="number" class="form-control" min="0" name="quantity" value="{{ $Expense->quantity }}" id="expense-quantity">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Amount</label>
                                            <input type="number" class="form-control" min="0" name="amount" value="{{ $Expense->amount }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Location</label>
                                            <input type="text" class="form-control" value="{{ $Expense->location }}" min="0" name="location">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('account_id') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Payment Type</label>
                                            <select name="account_id" class="form-control" id="entry-Payment">
                                                <option value="1" {{ (1 == $Expense->account_id) ? 'selected':'' }}>Cash</option>
                                                @foreach(Auth::user()->Accounts as $Account)
                                                    <option value="{{ $Account->id }}" {{ ($Account->id == $Expense->account_id) ? 'selected':'' }}>{{ $Account->account }} - {{ !empty($Account->HolderName)? $Account->HolderName:'' }}</option>
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
                                                <option value="1" {{ ($Expense->status ==1)?'selected':'' }}>Paid</option>
                                                <option value="0" {{ ($Expense->status ==0)?'selected':'' }}>Not Paid</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('discription') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Description</label>
                                            <textarea class="form-control" name="discription">{{ $Expense->discription }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            @if($Trips->status ==0)
                                <div align="center">
                                    <button type="submit" class="btn btn-info">Update Expense</button>
                                </div>
                            @endif
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-sm-12">
                                <div class="c-field u-mb-medium">
                                    <textarea class="form-control" id="expense-LastData" disabled=""></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection