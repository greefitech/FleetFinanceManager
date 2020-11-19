@extends('client.layout.master')

@section('MasterMenu')
active menu-open
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
          	@component('layouts.component.box-pannel',['title'=>'Service Details','color'=>env('TABPANELCOLOR')])
				<div class="row">
                    <div class="col-xs-12">
                        <center><h4>{{ $Tyre->tyre_number }} Status Tyre</h4></center>
                    </div>
                </div>

                    <table class="table table-hover table-striped table-bordered" id="TyreListTable">
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
                </table>

             

            @endcomponent
        </div>
    </div>
@endsection

@section('script')

    <script>
        var NewsApp= $('#TyreListTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ action("ClientController\Master\TyreController@show",$Tyre->id) }}',
            "columns": [
                {data: 'transaction', name: 'transaction'},
                {data: 'created_at', name: 'created_at'},
                {data: 'vehicleNumber', name: 'vehicleNumber'},
                {data: 'position', name: 'position'},
                {data: 'current_depth', name: 'current_depth'},
                {data: 'km', name: 'km'},
                {data: 'manager', name: 'manager'},
                {data: 'Staff', name: 'Staff'},
            ],
        });
    </script>
@endsection