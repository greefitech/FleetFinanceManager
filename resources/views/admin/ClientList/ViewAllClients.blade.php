@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Clients</span>
                    <span class="info-box-number"><center><span style="color: green;font-size: 30px">{{ $Clients->count() }}</span></center></span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
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
                        @if(!$Clients->isEmpty())
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Client Name	</th>
                                        <th>Transport Name</th>
                                        <th>Mobile</th>
                                        <th>Address</th>
                                        <th>Vehicle Credits</th>
                                        <th>Total Vehicle Added</th>
                                        <th>Referred By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Clients as $Client)
                                        <tr class="c-table__row">
                                            <td>{{$Client->name}}</td>
                                            <td>{{$Client->transportName}}</td>
                                            <td>{{$Client->mobile}}</td>
                                            <td>{{$Client->address}}</td>
                                            <td>{{ $Client->vehicleCredit }}</td>
                                            <td>{{ $Client->vehicles->count() }}</td>
                                            <td>{{ GetClientReferenceName($Client->referral_number) }}</td>
                                            <td>

{{--                                                <div class="input-group input-group-sm">--}}
{{--                                                    <div class="input-group-btn">--}}
{{--                                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action--}}
{{--                                                            <span class="fa fa-caret-down"></span></button>--}}
{{--                                                        <ul class="dropdown-menu">--}}
{{--                                                            <li><a href="">Entries</a></li>--}}
{{--                                                            <li><a href="">Expense</a></li>--}}
{{--                                                            <li><a href="">Halt</a></li>--}}
{{--                                                            <li class="divider"></li>--}}
{{--                                                            <li><a href="">Edit</a></li>--}}
{{--                                                        </ul>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}

                                                <a href="/admin/Clients/VehicleList/{{$Client->id}}"><button type="button" class="btn btn-success btn-sm">Vehicle List</button></a>
                                                <a href="/admin/Clients/{{$Client->id}}/editClient"><button type="button" class="btn btn-primary btn-sm">Edit Client</button></a>
                                                <a href=""><button type="button" class="btn btn-info btn-sm">Vehicle Credit</button></a>
{{--                                                <a href="#"><button type="button" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button></a>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Clients till now!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection