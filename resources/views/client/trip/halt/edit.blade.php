@extends('client.layout.master')

@section('content')


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>edit Halt</center>
                    </h4>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.UpdateHalt',$Halt->id) }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('tripId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Trip</label>
                                            <select name="tripId" class="form-control"  id="entry-trip">
                                                <option value="">Select Trip</option>
                                                @foreach(Auth::user()->NotCompletedTrips as $Trip)
                                                    <option value="{{ $Trip->id }}" {{ ($Trip->id == $Halt->tripId)?'selected':'' }}>{{ $Trip->vehicle->vehicleNumber }} - {{ $Trip->tripName }} - {{ $Trip->dateFrom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Date</label>
                                            <input type="date" class="form-control" value="{{ $Halt->date }}" placeholder="Enter Date" name="date" id="entry-dateFrom">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('vehicleId') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle</label>
                                            <select name="vehicleId" class="form-control" id="entry-vehicle">
                                                <option value="">Select Vehicle</option>
                                                @foreach(Auth::user()->vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}" {{ ($vehicle->id==$Halt->vehicleId)?'selected':'' }}>{{ $vehicle->vehicleNumber }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Location</label>
                                            <input class="form-control" type="text" value="{{ $Halt->location }}" name="location">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('reason') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Reason</label>
                                            <input class="form-control" type="text" value="{{ $Halt->reason }}" name="reason">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('discription') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Description</label>
                                            <textarea class="form-control" name="discription">{{ $Halt->discription }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Update Halt</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection