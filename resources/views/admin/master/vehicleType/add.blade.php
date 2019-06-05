@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add Vehicle Type</center>
                    </h4>
                    <a href="{{ route('admin.ViewVehicleType') }}" class="btn btn-info pull-right">View Vehicle Type</a>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" action="{{route('admin.SaveVehicleType') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('vehicleType') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Vehicle Type</label>
                                            <input type="text" class="form-control" value="{{ old('vehicleType') }}" name="vehicleType" placeholder="Enter Vehicle Type">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('wheel') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Wheel</label>
                                            <input type="number" min="0" class="form-control" value="{{ old('wheel') }}" name="wheel" placeholder="Enter Wheel">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Vehicle Type</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection