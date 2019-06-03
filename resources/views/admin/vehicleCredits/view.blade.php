@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>View Vehicle Credit</center>
                    </h4>
{{--                    <a href="{{ route('admin.adminAccountAdd') }}" class="btn btn-info pull-right">Add Admin</a>--}}
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty($Data['Clients']))
                            <table  class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Transport Name</th>
                                        <th>Mobile Number</th>
                                        <th>Address</th>
                                        <th>No.of Vehicle</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Data['Clients'] as $Clients)
                                        @if(!empty($Clients))
                                            <tr>
                                                <td>{{ $Clients->name }}</td>
                                                <td>{{ $Clients->transportName }}</td>
                                                <td>{{ $Clients->mobile }}</td>
                                                <td>{{ $Clients->address }}</td>
                                                <td>{{ $Clients->vehicleCredit }}</td>
                                                <td>
                                                    <a href="{{ route('admin.EditVehicleCredit') }}"><button type="button" class="btn btn-success">Add</button></a>
                                                    <a href=""><button type="button" class="btn btn-danger">Delete</button></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Admin Records!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection