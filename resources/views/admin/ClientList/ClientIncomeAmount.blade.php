@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Client Income Amount</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$Clients->isEmpty())
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Client Name</th>
                                        <th>Vehicle Credits</th>
                                        <th>Transport Name</th>
                                        <th>Paid Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Clients as $Client)
                                    <?php $VehicleCredit = $Client->VehicleCredits;
                                           ;?>
                                        <tr>
                                            <td>{{ date("d-m-Y", strtotime($Client->created_at)) }}</td>
                                            <td>{{ $Client->name }}</td>
                                            <td>{{ $Client->vehicleCredit }}</td>
                                            <td>{{ $Client->transportName }}</td>
                                            <td>{{ $VehicleCredit->sum('paid_amount') }}</td>
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