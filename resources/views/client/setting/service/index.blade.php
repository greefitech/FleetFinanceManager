@extends('client.layout.master')

@section('setting')
active menu-open
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
          	@component('layouts.component.box-pannel',['title'=>'Vehicle Service List','color'=>env('TABPANELCOLOR')])
				@slot('button')
                    <div class="row">
                        <div class="col-xs-12">
                            <center><h4>View {{ $Vehicle->vehicleNumber }} Services</h4></center>
                        </div>
                    </div>
                @endslot    
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <table class="table table-hover table-striped table-bordered" id="ServiceListTable">
                    <thead>
                        <tr>
                            <th>Service</th>
                            
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    	@foreach($VehicleServices as $key=>$VehicleService)
                            <tr>
                                <td>{{ $VehicleService->title }}</td>
                                <td> <a href="{{ action('ClientController\Setting\ServiceController@editService',[$VehicleService->id,$Vehicle->id]) }}"><button class="btn btn-primary">Update Services</button></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            @endcomponent
        </div>
    </div>

@endsection

