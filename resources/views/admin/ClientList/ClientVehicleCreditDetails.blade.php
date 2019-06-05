@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Credits</span>
                    <span class="info-box-number"><center><span style="color: green;font-size: 30px">{{ $Client->vehicleCredit }}</span></center></span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Payment</span>
                    <span class="info-box-number"><center><span style="color: green;font-size: 30px">{{ $Client->vehicleCredit }}</span></center></span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Balance Payment</span>
                    <span class="info-box-number"><center><span style="color: green;font-size: 30px">{{ $Client->vehicleCredit }}</span></center></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>{{ $Client->name }} Credit List</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$VehicleCredits->isEmpty())
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Credit</th>
                                        <th>Base Price</th>
                                        <th>Total Amount</th>
                                        <th>Paid amount</th>
                                        <th>Credit To / Paid To</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($VehicleCredits as $VehicleCredit)
                                        <tr>
                                            <td>{{ date("d-m-Y", strtotime($VehicleCredit->created_at)) }}</td>
                                            <td>{{ $VehicleCredit->credit }}</td>
                                            <td>{{ $VehicleCredit->base_price }}</td>
                                            <td>{{ $VehicleCredit->total_amount }}</td>
                                            <td>{{ $VehicleCredit->paid_amount }}</td>
                                            <td>{{ $VehicleCredit->Admin->name }}</td>
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