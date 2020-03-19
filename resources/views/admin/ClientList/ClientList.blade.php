@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Clients</span>
                    <span class="info-box-number"><center><span style="color: green;font-size: 30px">{{ $Clients->count() }}</span></center></span>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="col-xs-12">
            @component('layouts.component.box-pannel',['Title'=>'Dashboard','MenuTitle'=>'Client List'])
                <div class="table-responsive">
                    @if(!$Clients->isEmpty())
                        <table  class="table table-bordered table-striped DataTable">
                            <thead>
                                <tr>
                                    <th>Client Name	</th>
                                    <th>Transport Name</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Vehicle Credits</th>
                                    <th>Vehicle Added</th>
                                    <th>Reference</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Clients as $Client)
                                    <tr>
                                        <td>{{$Client->name}}</td>
                                        <td>{{$Client->transportName}}</td>
                                        <td>{{$Client->mobile}}</td>
                                        <td>{{$Client->address}}</td>
                                        <td>{{ $Client->vehicleCredit }}</td>
                                        <td>{{ $Client->vehicles->count() }}</td>
                                        <td>{{ GetClientReferenceName($Client->referral_number) }}</td>
                                        <td style="color: {{ ($Client->client_status == 1)?'green':'red' }}">{{ ($Client->client_status == 1)?'Active':'In Active' }}</td>
                                        <td>
                                            <form action="{{ route('admin.DeleteClient', [$Client->id]) }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                                <a href="{{ route('admin.VehicleListClientWise',$Client->id) }}"><button type="button" class="btn btn-success btn-sm">Vehicle List</button></a>
                                                <a href="{{ route('admin.EditClientList',$Client->id) }}"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Client</button></a>
                                                <a href="{{ route('admin.ClientVehicleCreditDetails',$Client->id) }}"><button type="button" class="btn btn-info btn-sm">Vehicle Credit</button></a>
                                            <button class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                                        </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <blockquote><p>No Clients till now!!</p></blockquote>
                    @endif
                </div>
            @endcomponent
        </div>
    </div>


@endsection