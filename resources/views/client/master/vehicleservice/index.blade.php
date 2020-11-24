@extends('client.layout.master')

@section('MasterMenu','active menu-open')

@push('BreadCrumbMenu')
   <li>Master</li>
   <li class="active"><a href="{{ action('ClientController\Master\VehicleServiceController@index') }}">Vehicle Service</a></li>
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">
            @component('client.layout.component.panel-head',['MenuTitle'=>'Vehicle Service','Title'=>'Vehicle Service List','color'=>env('TABPANELCOLOR')])
                @slot('Button')
                     <a href="{{ action('ClientController\Master\VehicleServiceController@create') }}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Service</a>
                @endslot

                <div class="table-responsive">
                     <table class="table table-bordered" id="VehicleService">
                        <thead>
                            <tr>
                                <th>Title</th>
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
        var Managers= $('#VehicleService').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ action("ClientController\Master\VehicleServiceController@index") }}',
            "columns": [
                {data: 'title', name: 'title'},
                {data: 'action', name: 'action'},
            ],
        });
    </script>
@endsection