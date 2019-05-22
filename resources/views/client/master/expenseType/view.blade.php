@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Vehicles</center>
                    </h4>
                    <a href="{{ route('client.AddVehicle') }}" class="btn btn-info pull-right">Add Vehicle</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty(auth()->user()->vehicles))
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Owner Name</th>
                                        <th>Vehicle Number</th>
                                        <th>Vehicle Name</th>
                                        <th>Model</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(auth()->user()->vehicles as $Vehicle)
                                        <tr>
                                            <td>{{ $Vehicle->ownerName }}</td>
                                            <td>{{ $Vehicle->vehicleNumber }}</td>
                                            <td>{{ $Vehicle->vehicleName }}</td>
                                            <td>{{ $Vehicle->modelNumber }}</td>
                                            <td>
{{--                                                <form action="" method="POST">--}}
{{--                                                    {{ csrf_field() }}--}}
{{--                                                    <input type="hidden" name="_method" value="DELETE">--}}
                                                    <a href="#" class="btn"><i class="fa fa-truck text-aqua"></i></a>
                                                    <a href="#" class="btn"><i class="fa fa-file text-aqua"></i></a>
                                                    <a href="{{ route('client.EditVehicle',$Vehicle->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
{{--                                                    <button href="" onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>--}}
{{--                                                </form>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Vehicle till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection