@extends('manager.layout.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Edit Vehicle</center>
                    </h4>
                    <a href="{{ route('manager.ViewVehicles') }}" class="btn btn-info pull-right">View Vehicle</a>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('manager.UpdateVehicle',$Vehicle->id) }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('ownerName') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Owner Name</label>
                                            <input type="text" class="form-control" min="0" value="{{ $Vehicle->ownerName }}" placeholder="Enter Owner Name" name="ownerName">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('vehicleNumber') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle Number</label>
                                            <input type="text" class="form-control" value="{{ $Vehicle->vehicleNumber }}" placeholder="Enter Vehicle Number" name="vehicleNumber">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('vehicleName') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle Name</label>
                                            <input type="text" class="form-control" value="{{ $Vehicle->vehicleName }}" placeholder="Enter Vehicle Name" name="vehicleName">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('modelNumber') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Model Number</label>
                                            <input type="text" class="form-control" value="{{ $Vehicle->modelNumber }}" placeholder="Enter Licence Number" name="modelNumber">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('vehicleLastKm') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle Last KM</label>
                                            <input type="number" class="form-control" min="0" value="{{ $Vehicle->vehicleLastKm }}" placeholder="Enter Vehicle Last KM" name="vehicleLastKm">
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
                                                    <option value="{{ $vehicleType->id }}" {{ ($vehicleType->id==$Vehicle->vehicleType)?'selected':'' }}>{{ $vehicleType->vehicleType }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('engine_number') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Engine Number</label>
                                            <input type="text" class="form-control" value="{{$Vehicle->engine_number }}" placeholder="Enter Engine Number" name="engine_number">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('chassis_number') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Chassis Number</label>
                                            <input type="text" class="form-control" value="{{$Vehicle->chassis_number }}" placeholder="Enter Chassis Number" name="chassis_number">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('manufacture_date') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Manufacturing Year</label>
                                            <input type="month" class="form-control" value="{{$Vehicle->manufacture_date }}" placeholder="Enter Manufacturing Year" name="manufacture_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('fuel_tank_capacity') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Fuel Tank Capacity</label>
                                            <input type="number" min="0" class="form-control" value="{{$Vehicle->fuel_tank_capacity }}" placeholder="Enter Fuel Tank Capacity" name="fuel_tank_capacity">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('vehicle_purchased_date') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Purchased Date</label>
                                            <input type="date" min="0" class="form-control" value="{{$Vehicle->vehicle_purchased_date }}" placeholder="Enter Purchased Date" name="vehicle_purchased_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('VehicleProfit') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle Profit</label>
                                            <input type="number" class="form-control" value="{{ $Vehicle->VehicleProfit }}" placeholder="Enter Vehicle Profit" name="VehicleProfit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Update Vehicle</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection