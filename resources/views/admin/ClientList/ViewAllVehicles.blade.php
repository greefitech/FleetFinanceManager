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
                    <span class="info-box-text">Total Vehicle Credit</span>
                    <span class="info-box-number"><center><span style="color: green;font-size: 30px">{{ $Client->vehicleCredit }}</span></center></span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Balance Vehicle Credit</span>
                    <span class="info-box-number"><center><span style="color: green;font-size: 30px">{{ $Client->vehicleCredit - count($Vehicles) }}</span></center></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>{{ $Client->name }} - {{ $Client->transportName }}</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$Vehicles->isEmpty())
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Owner Name</th>
                                        <th>Vehicle Number</th>
                                        <th>Vehicle Name</th>
                                        <th>Model Number</th>
                                        <th>Vehicle Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Vehicles as $Vehicle)
                                        <tr class="c-table__row">
                                            <td>{{ $Vehicle->ownerName }}</td>
                                            <td>{{ $Vehicle->vehicleNumber }}</td>
                                            <td>{{ $Vehicle->vehicleName }}</td>
                                            <td>{{ $Vehicle->modelNumber }}</td>
                                            <td>{{ @$Vehicle->GetVehicleType->vehicleType }}</td>
                                            <td>
                                                <a href=""><button type="button" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button></a>
                                                <a href=""><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>
                                                <a href=""><button type="button" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Vehicle till now!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection