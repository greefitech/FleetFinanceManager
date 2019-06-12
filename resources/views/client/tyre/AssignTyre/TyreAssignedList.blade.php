@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>{{ $Vehicle->vehicleNumber }} Assigned Tyre List</center>
                    </h4>
                    <a href="{{ route('client.AddAssignTyre',$Vehicle->id ) }}"><button type="button" class="btn btn-info btn-sm pull-right">Assign Vehicle Tyre</button></a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$AssignTyres->isEmpty())
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Tyre Number</th>
                                        <th>Position</th>
                                        <th>Last Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($AssignTyres as $AssignTyre)
                                        <tr>
                                            <td><a href="{{ !empty($AssignTyre->Tyre)?route('client.EditTyre',$AssignTyre->Tyre->id):'#' }}">{{ !empty($AssignTyre->Tyre)?$AssignTyre->Tyre->tyre_number:'NA' }}</a></td>
                                            <td>{{ ucfirst($AssignTyre->position) }}</td>
                                            <td>{{ $AssignTyre->updated_at }}</td>
                                            <td>
                                                <a href="{{ route('client.AddTyreCurrentStatusVehicle',[$Vehicle->id,$AssignTyre->id]) }}" class="btn"><i class="fa fa-cog text-aqua"></i></a>
                                                <a href="{{ route('client.EditVehicleAssignTyre',[$Vehicle->id,$AssignTyre->id]) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Tyre List till now!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection