@extends('client.layout.master')

@section('MasterMenu','active')

@push('BreadCrumbMenu')
   <li>Master</li>
   <li class="active"><a href="{{ action('ClientController\CustomerController@index') }}">Customer</a></li>
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">

            @component('client.layout.component.panel-head',['MenuTitle'=>'Customers','Title'=>'Customers List','color'=>env('TABPANELCOLOR')])
                @slot('Button')
                <a href="{{ action('ClientController\CustomerController@create') }}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Customer</a>
                @endslot

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

            @endcomponent

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

