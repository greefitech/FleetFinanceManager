@extends('client.layout.master')

@section('content')


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Edit Income</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.UpdateIncome',$Income->id) }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group{{ $errors->has('tripId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Trip</label>
                                            <select name="tripId" class="form-control" id="entry-trip">
                                                <option value="">Select Trip</option>
                                                @foreach(Auth::user()->NotCompletedTrips as $Trip)
                                                    <option value="{{ $Trip->id }}" {{ ($Trip->id == $Income->tripId)?'selected':'' }}>{{ $Trip->vehicle->vehicleNumber }} - {{ $Trip->tripName }} - {{ $Trip->dateFrom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Date</label>
                                            <input type="date" class="form-control" value="{{ $Income->date }}" placeholder="Enter Date" name="date"  id="entry-dateFrom">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle</label>
                                            <select name="vehicleId" class="form-control" id="entry-vehicle">
                                                <option value="">Select Vehicle</option>
                                                @foreach(Auth::user()->vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}" {{ ($vehicle->id==$Income->vehicleId)?'selected':'' }}>{{ $vehicle->vehicleNumber }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('customerId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Customer</label>
                                            <select name="customerId" class="form-control">
                                                <option value="">Select Customer</option>
                                                @foreach(Auth::user()->customers as $customer)
                                                    <option value="{{ $customer->id }}" {{ ($customer->id==$Income->customerId)?'selected':'' }}>{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('account_id') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Payment Type</label>
                                            <select name="account_id" class="form-control">
                                                <option value="1">Cash</option>
                                                @foreach(Auth::user()->Accounts as $Account)
                                                    <option value="{{ $Account->id }}" {{ ($Account->id==$Income->account_id)?'selected':'' }}>{{ $Account->account }} - {{ !empty($Account->HolderName)? $Account->HolderName:'' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('recevingAmount') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Receving Amount</label>
                                            <input type="number" class="form-control" min="0" value="{{ $Income->recevingAmount }}" name="recevingAmount">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('discountAmount') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Discount Amount</label>
                                            <input type="number" class="form-control" min="0" value="{{ $Income->discountAmount }}" name="discountAmount">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Update Income</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection