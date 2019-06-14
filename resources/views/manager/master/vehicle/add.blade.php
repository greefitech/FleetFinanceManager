@extends('client.layout.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add Vehicle</center>
                    </h4>
                    <a href="{{ route('client.ViewVehicles') }}" class="btn btn-info pull-right">View Vehicle</a>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.SaveVehicle') }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('ownerName') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Owner Name</label>
                                            <input type="text" class="form-control" min="0" value="{{ old('ownerName') }}" placeholder="Enter Owner Name" name="ownerName">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('vehicleNumber') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle Number</label>
                                            <input type="text" class="form-control" value="{{ old('vehicleNumber') }}" placeholder="Enter Vehicle Number" name="vehicleNumber">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('vehicleName') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle Name</label>
                                            <input type="text" class="form-control" value="{{ old('vehicleName') }}" placeholder="Enter Vehicle Name" name="vehicleName">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('modelNumber') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Model Number</label>
                                            <input type="text" class="form-control" value="{{ old('modelNumber') }}" placeholder="Enter Model Number" name="modelNumber">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('vehicleLastKm') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle Last KM</label>
                                            <input type="number" class="form-control" min="0" value="{{ old('vehicleLastKm') }}" placeholder="Enter Vehicle Last KM" name="vehicleLastKm">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('vehicleType') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle Type</label>
                                            <select class="form-control" name="vehicleType">
                                                <option value="">Select Vehicle Type</option>
                                                @foreach($VehicleTypes as $vehicleType)
                                                    <option value="{{ $vehicleType->id }}" {{ ($vehicleType->id==old('vehicleType'))?'selected':'' }}>{{ $vehicleType->vehicleType }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('VehicleProfit') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle Profit</label>
                                            <input type="number" class="form-control" value="{{ old('VehicleProfit') }}" placeholder="Enter Vehicle Profit" name="VehicleProfit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Vehicle</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection