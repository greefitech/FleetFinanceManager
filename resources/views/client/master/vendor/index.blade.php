@extends('client.layout.master'
)
@section('MasterMenu','active')

@push('BreadCrumbMenu')
   <li>Master</li>
   <li class="active"><a href="{{ action('ClientController\Master\VendorController@index') }}">Vendor</a></li>
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">
              @component('client.layout.component.panel-head',['MenuTitle'=>'Vendor','Title'=>'Vendor List','color'=>env('TABPANELCOLOR')])
                @slot('Button')
                     <a href="{{ action('ClientController\Master\VendorController@create') }}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Vendor</a>
                @endslot

                <div class="table-responsive">
                    <table  class="table table-bordered table-striped table-hover" id="CustomerTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Balance</th>
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
        ajax: '{{ action('ClientController\Master\VendorController@index') }}',
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'mobile', name: 'mobile'},
            {data: 'address', name: 'address'},
            {data: 'balance', name: 'balance'},
            {data: 'action', name: 'action'},
        ]

    });
</script>

@endsection