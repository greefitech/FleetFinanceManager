@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Services</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$ServiceTypes->isEmpty())
                            <table  class="table table-bordered table-striped DataTable table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Service type</th>
                                        <th>Last Service</th>
                                        <th>Next Service</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ServiceTypes as $servicetype)
                                        <?php 
                                            $date = \Carbon\Carbon::today()->subDays(30)->toDateString();
                                            $GetServiceDetails = GetServiceDate(@$servicetype->id,$VehicleId); 
                                            $CurrentKM = GetVehicleCurrentKm($VehicleId)->endKm;
                                        ?>
                                        @if($servicetype->type == 'date')
                                            <tr style="color: {{ isset($GetServiceDetails) ? ($GetServiceDetails->next_service_date > $date ? 'green' :'red') : '' }}">
                                                <td>{{ $servicetype->name }}</td>
                                                <td>{{ ucfirst($servicetype->type) }}</td>
                                                <td>{{ isset($GetServiceDetails) ? date('d-m-Y', strtotime(@$GetServiceDetails->next_service_date)) : '-' }}</td>
                                                <td>{{ isset($GetServiceDetails) ? date('d-m-Y', strtotime(@$GetServiceDetails->next_service_date)) : '-' }}</td>
                                                <td>
                                                    <a href="{{ action('ClientController\ServiceController@UpdateServiceDetail',[$VehicleId,$servicetype->id])}}" class="btn btn-info">Update Service</a>
                                                </td>
                                            </tr>
                                        @else
                                            <tr style="color: {{ isset($GetServiceDetails) ? ($GetServiceDetails->next_service_km > $CurrentKM ? 'green' :'red') : '' }}">
                                                <td>{{ $servicetype->name }}</td>
                                                <td>{{ ucfirst($servicetype->type) }}</td>
                                                <td>{{ isset($GetServiceDetails) ? @$GetServiceDetails->next_service_km : '-' }}</td>
                                                <td>{{ isset($GetServiceDetails) ? @$GetServiceDetails->next_service_km : '-' }}</td>
                                                <td>
                                                    <a href="{{ action('ClientController\ServiceController@UpdateServiceDetail',[$VehicleId,$servicetype->id])}}" class="btn btn-info">Update Service</a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Services till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
