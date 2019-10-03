@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Update Services</center>
                        <h3><center>{{$servicetypes->name}}</center></h3>
                    </h4>
                    <a href="{{ action('ClientController\ServiceController@viewvehicle') }}" class="btn btn-info pull-right">View Vehicle</a>
                </div>
               
                <div class="box-body">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Date</th>
                                @if($servicetypes->type == 'km')
                                    <th>Next Service km</th>
                                @else
                                    <th>Next Service Date</th>
                                @endif
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <form action="{{ action('ClientController\ServiceController@SaveServiceStatus',[$VehicleId,$servicetypes->id]) }}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-sm-10">
                                            <input type='date' id='hasta' class="form-control" name="date" value='<?php echo date('Y-m-d');?>'>
                                        </div>
                                        <td>
                                            <div class="col-sm-10">
                                                @if($servicetypes->type == 'km')
                                                    <input type="text" class="form-control" onkeypress="return isNumber(event)" placeholder="Enter Next Service" name="next_service_km">
                                                @else
                                                    <input type="date" min="0" class="form-control" placeholder="Enter Next Service Date" name="next_service_date">
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <input type="submit" class="btn btn-info">
                                        </td>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
