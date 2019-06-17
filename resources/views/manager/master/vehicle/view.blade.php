@extends('manager.layout.master')

@section('content')

    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12"></div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Balance Vehicle Count</span>
                    <span class="info-box-number"><center><span style="color: green;font-size: 30px">{{ GetClientManager(Auth::user()->clientid)->vehicleCredit - count(GetClientManager(Auth::user()->clientid)->vehicles) }}</span></center></span>
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
                        <center>Vehicles</center>
                    </h4>
{{--                    <a href="{{ route('manager.AddVehicle') }}" class="btn btn-info pull-right">Add Vehicle</a>--}}
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty(GetClientVehicle(Auth::user()->clientid)))
                            <table  class="table table-bordered table-striped DataTable table-hover">
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
                                    @foreach(GetClientVehicle(Auth::user()->clientid) as $Vehicle)
                                        <tr>
                                            <td>{{ $Vehicle->ownerName }}</td>
                                            <td>{{ $Vehicle->vehicleNumber }}</td>
                                            <td>{{ $Vehicle->vehicleName }}</td>
                                            <td>{{ $Vehicle->modelNumber }}</td>
                                            <td>
                                                <form action="" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    @if(!empty($Vehicle->FinancialIndicator))
                                                        <a href="{{ route('manager.ViewFinancialIndicators',$Vehicle->FinancialIndicator->id) }}" class="btn"><i class="fa fa-truck text-aqua"></i></a>
                                                    @else
                                                        <a href="{{ route('manager.AddFinancialIndicators',$Vehicle->id) }}" class="btn"><i class="fa fa-truck text-aqua"></i></a>
                                                    @endif
                                                    <a href="{{ route('manager.ViewDocuments',$Vehicle->id) }}" class="btn"><i class="fa fa-file text-aqua"></i></a>
                                                    <a href="{{ route('manager.EditVehicle',$Vehicle->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
{{--                                                    <button href="" onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>--}}
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Vehicle till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection