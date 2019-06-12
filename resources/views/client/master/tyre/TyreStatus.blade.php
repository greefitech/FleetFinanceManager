@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Tyres Status</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$TyreLogs->isEmpty())
                            <table  class="table table-bordered table-striped DataTable table-hover">
                                <thead>
                                    <tr>
                                        <th>Transaction</th>
                                        <th>Date</th>
                                        <th>Lorry</th>
                                        <th>Position</th>
                                        <th>Depth</th>
                                        <th>KM</th>
                                        <th>Manager</th>
                                        <th>Driver</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($TyreLogs as $TyreLog)
                                        <tr>
                                            <td>{{ $TyreLog->transaction }}</td>
                                            <td>{{ $TyreLog->created_at }}</td>
                                            <td>{{ @$TyreLog->vehicle->vehicleNumber }}</td>
                                            <td>{{ ucfirst($TyreLog->position) }}</td>
                                            <td>{{ $TyreLog->current_depth }}</td>
                                            <td>{{ $TyreLog->km }}</td>
                                            <td>{{ @$TyreLog->manager->name }}</td>
                                            <td>{{ @$TyreLog->Staff->name }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Tyre Status till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection