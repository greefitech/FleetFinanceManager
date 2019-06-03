@extends('admin.layout.master')

@section('ClientList')
    is-active
@endsection

@section('content')


    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">No .of Vehicle Credit</span>
                    <span class="info-box-number"><center><span style="color: green;font-size: 30px">{{ $Clients->vehicleCredit }}</span></center></span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Balance Vehicle Count</span>
                    <span class="info-box-number"><center><span style="color: green;font-size: 30px">{{ $Clients->vehicleCredit - count($Vehicles) }}</span></center></span>
                </div>
            </div>
        </div>

        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-4 col-sm-6 col-xs-12"></div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Vehicle List - {{ $Clients->name }} - {{ $Clients->transportName }}</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty($Vehicles))
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                <tr>
                                    <th>Owner Name</th>
                                    <th>Vehicle Number</th>
                                    <th>Vehicle Type</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($Vehicles as $Vehicle)
                                    <tr class="c-table__row">
                                        <td>{{ $Vehicle->ownerName }}</td>
                                        <td>{{ $Vehicle->vehicleNumber }}</td>
                                        <td>{{ $Vehicle->GetVehicleType->vehicleType }}</td>
                                        <td>
                                            <a href=""><button type="button" class="btn btn-success">Edit</button></a>
                                            <a href=""><button type="button" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button></a>

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