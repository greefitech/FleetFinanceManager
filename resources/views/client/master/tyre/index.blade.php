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
	                        <center><h4>View Tyre</h4></center>
	                        <a href="{{ action('ClientController\Master\TyreController@create') }}" class="btn btn-info pull-right">Add Tyre</a>
	                    </div>
	                </div>

 				<meta name="csrf-token" content="{{ csrf_token() }}">
                <table class="table table-hover table-striped table-bordered" id="TyreListTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Tyre Number</th>
                            <th>Vehicle</th>
                            <th>Manufacture Company</th>
                            <th>Purchased From</th>
                            <th>condition</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>


            @endcomponent
        </div>
    </div>
@endsection

@section('script')

    <script>
        var Tyre= $('#TyreListTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ action("ClientController\Master\TyreController@index") }}',
            "columns": [
                {data: 'date', name: 'date'},
                {data: 'tyre_number', name: 'tyre_number'},
                {data: 'vehicleNumber', name: 'vehicleNumber'},
                {data: 'manufacture_company', name: 'manufacture_company'},
                {data: 'purchased_from',name: 'purchased_from'},
                {data: 'condition', name: 'condition'},
                {data: 'action', name: 'action'},
            ],
        });

        $('#TyreListTable').on('click', '.Delete', function (e) { 
            e.preventDefault();
            var url = $(this).attr('href');
            var DeleteMessage = $(this).attr('DeleteMessage');
            swal({
                title: "Are you sure?",
                text: DeleteMessage,
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: false,
                closeOnCancel: false
            },function(isConfirm) {
                if (isConfirm) {
                    $.ajax(
                        {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                    }).always(function (data) {
                        Tyre.ajax.reload();
                        swal("Deleted!", data.msg, data.status);
                    });
                } else {
                    swal("Cancelled", "Your Data is safe", "error");
                }
            });
        });
    </script>
@endsection