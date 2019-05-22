@extends('client.layout.master')

@section('content')


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Edit Trip</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.UpdateTrip',$Trip->id) }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('dateFrom') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Date From</label>
                                            <input type="date" class="form-control" value="{{ $Trip->dateFrom }}" placeholder="Enter Date" name="dateFrom">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('dateTo') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Date To</label>
                                            <input type="date" class="form-control" value="{{ $Trip->dateTo }}" placeholder="Enter Date To" name="dateTo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle</label>
                                            <select class="form-control" name="vehicleId">
                                                <option value="">Select Vehicle</option>
                                                @foreach(Auth::user()->vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}" {{ ($vehicle->id == $Trip->vehicleId) ?'selected':'' }}>{{ $vehicle->vehicleNumber }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('startKm') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Starting KM</label>
                                            <input type="text" id="entry-startkm" class="form-control CalculateKm" value="{{ $Trip->startKm }}" placeholder="Enter Starting KM" name="startKm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('endKm') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Ending KM</label>
                                            <input type="text" id="entry-endkm" class="form-control CalculateKm" value="{{ $Trip->endKm }}" placeholder="Enter Ending KM" name="endKm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('totalKm') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Total KM</label>
                                            <input type="text" id="entry-totalkm" class="form-control" value="{{ $Trip->totalKm }}" placeholder="Enter Total KM" name="totalKm" readonly="">
                                            <span id="ErrorTotal"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Staff 1</label>
                                            <select class="form-control" name="staff1">
                                                 <option value="">Select Staff</option>
                                                @foreach(Auth::user()->staffs as $staff)
                                                    <option value="{{ $staff->id }}" {{ ($staff->id==$Trip->staff1)?'selected':'' }}>{{ $staff->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Staff 2</label>
                                            <select class="form-control" name="staff2">
                                                 <option value="">Select Staff</option>
                                                @foreach(Auth::user()->staffs as $staff)
                                                    <option value="{{ $staff->id }}" {{ ($staff->id==$Trip->staff1)?'selected':'' }}>{{ $staff->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Staff 3</label>
                                            <select class="form-control" name="staff3">
                                                 <option value="">Select Staff</option>
                                                @foreach(Auth::user()->staffs as $staff)
                                                    <option value="{{ $staff->id }}" {{ ($staff->id==$Trip->staff1)?'selected':'' }}>{{ $staff->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('advance') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Advance</label>
                                            <input type="numbere" min="0" class="form-control" value="{{ $Trip->advance }}" placeholder="Enter Advance" name="advance">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Update Trip</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection