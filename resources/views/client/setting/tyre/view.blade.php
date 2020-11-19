@extends('client.layout.master')

@section('SettingMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
          	@component('layouts.component.box-pannel',['title'=>'Service Details','color'=>env('TABPANELCOLOR')])
                <div class="row">
                    <div class="col-xs-12">
                        <center><h4>{{ $Vehicle->vehicleNumber }} Tyre List</h4></center>
                        <a href="{{ action('ClientController\Setting\TyreController@edit',$Vehicle->id ) }}"><button type="button" class="btn btn-info btn-sm pull-right">Assign Vehicle Tyre</button></a>
                    </div>
                </div>
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
                                <td><a href="{{ !empty($AssignTyre->Tyre)?action('ClientController\Master\TyreController@show',$AssignTyre->Tyre->id):'#' }}">{{ !empty($AssignTyre->Tyre)?$AssignTyre->Tyre->tyre_number:'NA' }}</a></td>
                                <td>{{ ucfirst($AssignTyre->position) }}</td>
                                <td>{{ date("d-m-Y h:m a", strtotime($AssignTyre->updated_at)) }}</td>
                                <td>
                                    <a href="{{ route('client.AddTyreCurrentStatusVehicle',[$Vehicle->id,$AssignTyre->id]) }}" class="btn"><i class="fa fa-cog text-aqua"></i></a>
                                    <a href="{{ route('client.EditVehicleAssignTyre',[$Vehicle->id,$AssignTyre->id]) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
             
            @endcomponent
        </div>
    </div>

    

@endsection


