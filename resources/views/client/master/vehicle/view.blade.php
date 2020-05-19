@extends('client.layout.master'
)
@section('MasterMenu','active')

@section('content')

    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12"></div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-truck"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Balance Vehicle Count</span>
                    <span class="info-box-number"><center><span style="color: green;font-size: 30px">{{ Auth::user()->vehicleCredit - count(Auth::user()->vehicles) }}</span></center></span>
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
                    <a href="{{ action('ClientController\VehicleController@create') }}" class="btn btn-info pull-right">Add Vehicle</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!auth()->user()->vehicles->isEmpty())
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
                                    @foreach(auth()->user()->vehicles as $Vehicle)
                                        <tr>
                                            <td>{{ $Vehicle->ownerName }}</td>
                                            <td>{{ $Vehicle->vehicleNumber }}</td>
                                            <td>{{ $Vehicle->vehicleName }}</td>
                                            <td>{{ $Vehicle->modelNumber }}</td>
                                            <td>
{{--                                                <form action="" method="POST">--}}
{{--                                                    {{ csrf_field() }}--}}
{{--                                                    <input type="hidden" name="_method" value="DELETE">--}}
                                                    @if(!empty($Vehicle->FinancialIndicator))
                                                        <a href="{{ route('client.ViewFinancialIndicators',$Vehicle->FinancialIndicator->id) }}" class="btn"><i class="fa fa-truck text-aqua"></i></a>
                                                    @else
                                                        <a href="{{ route('client.AddFinancialIndicators',$Vehicle->id) }}" class="btn"><i class="fa fa-truck text-aqua"></i></a>
                                                    @endif
                                                    <a href="{{ route('client.ViewDocuments',$Vehicle->id) }}" class="btn"><i class="fa fa-file text-aqua"></i></a>
                                                    <a href="{{ action('ClientController\VehicleController@edit',$Vehicle->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
{{--                                                    <button href="" onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>--}}
{{--                                                </form>--}}
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