@extends('client.layout.master')

@section('MasterMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Customers</center>
                    </h4>
                    <a href="{{ action('ClientController\CustomerController@create') }}" class="btn btn-info pull-right">Add Customer</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table  class="table table-bordered table-striped table-hover" id="CustomerTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Type</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    var Customer= $('#CustomerTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ action('ClientController\CustomerController@index') }}',
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'mobile', name: 'mobile'},
            {data: 'address', name: 'address'},
            {data: 'type', name: 'type'},
            {data: 'created_by', name: 'created_by'},
            {data: 'action', name: 'action'},
        ]

    });
</script>

@endsection

