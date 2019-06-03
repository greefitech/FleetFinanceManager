@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">No .of Clients</span>
                    <span class="info-box-number"><center><span style="color: green;font-size: 30px">{{ count($Data['Clients']) }}</span></center></span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
{{--            <div class="info-box">--}}
{{--                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>--}}
{{--                <div class="info-box-content">--}}
{{--                    <span class="info-box-text">No.Of Vehicle</span>--}}
{{--                    <span class="info-box-number"><center><span style="color: green;font-size: 30px">--}}
{{--                        @foreach($Data['Clients'] as $key=>$vehicleCredit)--}}
{{--                                    {{ $vehicleCredit->vehicleCredit }}--}}
{{--                        @endforeach--}}
{{--                    </span></center></span>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>

        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-4 col-sm-6 col-xs-12"></div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Client List</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty($Data['Clients']))
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                <tr>
                                    <th>Client Name	</th>
                                    <th>Transport</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>No.of Credited Vehicle</th>
                                    <th>Client Total Vehicle</th>
                                    <th>Reffered By </th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($Data['Clients'] as $Client)
                                    <tr class="c-table__row">
                                        <td>{{$Client->name}}</td>
                                        <td>{{$Client->transportName}}</td>
                                        <td>{{$Client->mobile}}</td>
                                        <td>{{$Client->address}}</td>
                                        <td>{{ $Client->vehicleCredit }}</td>
                                        <td>{{ count($Client->vehicles) }}</td>
                                        @if($Client->referral_number != '')
                                            @foreach($Client->refferedBY as $refferedBY)
                                                <td>{{ $refferedBY->name }}</td>
                                            @endforeach
                                        @else
                                            <td>Greefi</td>
                                        @endif
                                        <td>
                                            <a href="/admin/Clients/VehicleList/{{$Client->id}}"><button type="button" class="btn btn-success">View Vehicle List</button></a>
                                            <a href="/admin/Clients/{{$Client->id}}/editClient"><button type="button" class="btn btn-primary">Edit Client</button></a>
                                            <a href="/admin/Clients/{{$Client->id}}/delete"><button type="button" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button></a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Customer till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection