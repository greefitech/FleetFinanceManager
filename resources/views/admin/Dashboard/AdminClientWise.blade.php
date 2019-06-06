@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>View Client Wise</center>
                    </h4>
                    {{--                    <a href="{{ route('admin.adminAccountAdd') }}" class="btn btn-info pull-right">Add Admin</a>--}}
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty($Clients))
                            <table  class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Transport Name</th>
                                        <th>Mobile Number</th>
                                        <th>Address</th>
                                        <th>Vehicle Credit</th>
                                        <th>Total Amount</th>
                                        <th>Balance Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Clients as $Clients)
                                        <tr>
                                            <td>{{ $Clients->name }}</td>
                                            <td>{{ $Clients->transportName }}</td>
                                            <td>{{ $Clients->mobile }}</td>
                                            <td>{{ $Clients->address }}</td>
                                            <td>{{ $Clients->vehicleCredit }}</td>
                                            <td>{{ VehicleCreditsClientWise($Clients->id)->sum('total_amount') }}</td>
                                            <td>{{ VehicleCreditsClientWise($Clients->id)->sum('total_amount') - (VehicleCreditsClientWise($Clients->id)->sum('paid_amount') + VehicleCreditPaymentClientWise($Clients->id)->sum('PaidAmount') + VehicleCreditPaymentClientWise($Clients->id)->sum('Discount')) }}</td>
                                            <td>
                                                <a href=""><button type="button" class="btn btn-success">View</button></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Client Records!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection