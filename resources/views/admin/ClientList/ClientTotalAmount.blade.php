@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Client Balance Amount</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!empty($Clients))
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Client Name</th>
                                        <th>Transport Name</th>
                                        <th>Vehicle Credits</th>
                                        <th>Total Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Clients as $Client)
                                    <?php $VehicleCredit = $Client->VehicleCredits;
                                           ;?>
                                        <tr>
                                            <td>{{ $Client->name }}</td>
                                            <td>{{ $Client->transportName }}</td>
                                            <td>{{ $Client->vehicleCredit }}</td>
                                            <td>{{ $VehicleCredit->sum('total_amount') }}</td>
                                            <td>{{ $VehicleCredit->sum('paid_amount') }}</td>
                                            <td>{{ $VehicleCredit->sum('total_amount')-$VehicleCredit->sum('paid_amount') }}</td>
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