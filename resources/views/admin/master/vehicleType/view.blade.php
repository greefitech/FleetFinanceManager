@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Vehicle Type</center>
                    </h4>
                    <a href="{{ route('admin.AddVehicleType') }}" class="btn btn-info pull-right">Add Vehicle Type</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty($VehicleTypes))
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">Vehicle Type</th>
                                        <th style="text-align:center">Wheel</th>
                                        <th style="text-align:center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($VehicleTypes as $VehicleType)
                                        <tr>
                                            <td>{{ $VehicleType->vehicleType }}</td>
                                            <td>{{ $VehicleType->wheel }}</td>
                                            <td style="text-align:center">
                                                <a href="{{ route('admin.vehicleTypeEdit',$VehicleType->id) }}"><button type="button" class="btn btn-success">Edit</button></a>
                                                <a href="{{ route('admin.DeleteVehicleType',$VehicleType->id) }}"><button type="button" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>Vehicle Type Didn't added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection