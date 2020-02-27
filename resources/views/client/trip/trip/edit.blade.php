@extends('client.layout.master')

@section('EntryMenu','active')

@section('content')

    <?php
    if($Trip->status == 1){
        $buttonName = 'Incomplete Trip';
        $button = 'danger';
        $status = 0;
    }else{
        $buttonName = 'Complete Trip';
        $status = 1;
        $button = 'success';
    }
    ?>


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Edit Trip</center>
                    </h4>

                    <div class="row">
                        <div class="form-group{{ $errors->has('dateFrom') ? ' has-error' : '' }}">
                            <div class="col-sm-12">
                                <form action="{{ route('client.UpdateTripStatus',$Trip->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="status" value="{{ $status }}">
                                    <button class="btn btn-{{ $button }} pull-right" type="submit">{{ $buttonName }}</button>
                                </form>
                            </div>
                        </div>
                    </div>

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
                                            <select class="form-control select2" name="vehicleId">
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
                                    <div class="form-group{{ $errors->has('staff1') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Staff 1</label>
                                            <select class="form-control select2" name="staff1">
                                                 <option value="">Select Staff</option>
                                                @foreach(Auth::user()->staffs as $staff)
                                                    <option value="{{ $staff->id }}" {{ ($staff->id==$Trip->staff1)?'selected':'' }}>{{ $staff->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('staff2') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Staff 2</label>
                                            <select class="form-control select2" name="staff2">
                                                 <option value="">Select Staff</option>
                                                @foreach(Auth::user()->staffs as $staff)
                                                    <option value="{{ $staff->id }}" {{ ($staff->id==$Trip->staff2)?'selected':'' }}>{{ $staff->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('staff3') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Staff 3</label>
                                            <select class="form-control select2" name="staff3">
                                                 <option value="">Select Staff</option>
                                                @foreach(Auth::user()->staffs as $staff)
                                                    <option value="{{ $staff->id }}" {{ ($staff->id==$Trip->staff3)?'selected':'' }}>{{ $staff->name }}</option>
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
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('tripName') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Trip Name</label>
                                            <input type="text" class="form-control" value="{{ $Trip->tripName }}" placeholder="Enter Trip Name" name="tripName">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <label>Trip Status</label><br>
                                            <div class="box box-{{ ($Trip->status == 0)?'danger':'success' }} box-solid">
                                                <div class="box-header">
                                                    <h3 class="box-title">{{ ($Trip->status == 0)?'Not Completed':'Completed' }}</h3>
                                                </div>
                                            </div>

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