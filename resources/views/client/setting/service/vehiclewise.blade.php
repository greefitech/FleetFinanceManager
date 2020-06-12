@extends('client.layout.master')

@section('SettingMenu')
active menu-open
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
          	@component('layouts.component.box-pannel',['title'=>'Vehicle List','color'=>env('TABPANELCOLOR')])
                <div class="box-header">
                    <h4><center>Service</center></h4>
                </div>
                <table class="table table-bordered" id="VehicleTable">
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
	                            	<a href="{{ action('ClientController\Setting\ServiceController@VehicleWiseService',$Vehicle->id) }}" class="btn btn-primary btn-sm">Services</a>
	                            </td>
	                        </tr>
                        @endforeach
                    </tbody>
                </table>

            @endcomponent
        </div>
    </div>

@endsection
