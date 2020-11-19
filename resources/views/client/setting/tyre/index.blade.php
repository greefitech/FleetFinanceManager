@extends('client.layout.master')

@section('SettingMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
          	@component('layouts.component.box-pannel',['title'=>'Service Details','color'=>env('TABPANELCOLOR')])
                <div class="row">
                    <div class="col-xs-12">
                        <center><h4>View Vehicle</h4></center>
                    </div>
                </div>
                <table  class="table table-bordered table-striped DataTable">
                    <thead>
                        <tr>
                            <th>Owner Name</th>
                            <th>Vehicle Number</th>
                            <th>Vehicle Name</th>
                            <th>Total Profit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(auth()->user()->vehicles as $Vehicle)
                            <tr>
                                <td>{{ $Vehicle->ownerName }}</td>
                                <td>{{ $Vehicle->vehicleNumber }}</td>
                                <td>{{ $Vehicle->vehicleName }}</td>
                                <td>{{ $Vehicle->TripKm->sum('totalKm') }}</td>
                                <td>
                                     <a href="{{ action('ClientController\Setting\TyreController@show',$Vehicle->id) }}" class="btn btn-primary btn-sm">View Tyre</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
             
            @endcomponent
        </div>
    </div>

    

@endsection


