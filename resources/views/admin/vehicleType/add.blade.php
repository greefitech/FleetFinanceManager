@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add Vehicle Type</center>
                    </h4>
                    <a href="{{ url('admin/vehicleType') }}" class="btn btn-info pull-right">View Vehicle Type</a>
                </div>

                <div class="box-body">

                    <form class="form-horizontal" action="{{route('admin.addVehicleType') }}" method="POST">
                        {{ csrf_field() }}

                        <div class="box-body">
                            <div class="row">
                                <div class="container">
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <label>Vehicle Type</label>
                                                <input type="text" class="form-control" value="{{ old('vehicleType') }}" name="vehicleType" placeholder="Enter Vehicle Type" id="vehicle_type">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="container">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-success btn-block">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection