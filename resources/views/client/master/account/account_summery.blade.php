@extends('client.layout.master')

@section('content')

 <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>                         
                        <a href="{{ route('client.ViewAccounts') }}"><button class="btn btn-info pull-right">View Accounts</button></a>
                        <center>{{ $Account->account }} {{ $Account->HolderName }} Summary</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!auth()->user()->Accounts->isEmpty())
                            <table  class="table table-bordered table-striped DataTable table-hover">
                                <thead>
                                    <tr>
                                        <th>Vehicle Number</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vehicles as $vehicle)
                                        @if( VehicleCreditPaymentAccountVehicleWise($AccountId,$vehicle->id)['Debit'] >0 || VehicleCreditPaymentAccountVehicleWise($AccountId,$vehicle->id)['Credit'] >0)
                                            <tr>
                                                <td>{{ $vehicle->vehicleNumber }}</td>
                                                <?php $VehicleId = $vehicle->id; ?>
                                                <td style="color: red;">{{ VehicleCreditPaymentAccountVehicleWise($AccountId,$vehicle->id)['Debit'] }}</td>
                                                <td style="color: green;">{{ VehicleCreditPaymentAccountVehicleWise($AccountId,$vehicle->id)['Credit'] }}</td>	
                                                <td>
                                                	<a href="{{ action('ClientController\AccountController@AccountDetailVehicleWise',[$AccountId,$vehicle->id]) }}" class="btn btn-primary brn-sm"><i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endif
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