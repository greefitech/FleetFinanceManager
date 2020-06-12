@extends('admin.layout.master')

@section('masterMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Vehicle Service</center>
                    </h4>
                    <a href="{{ action('AdminControllers\Master\VehicleServiceController@create') }}" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Add</a>
                </div>
                <div class="box-body">
                    
                    <table class="table table-bordered" id="VehicleService">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        var Managers= $('#VehicleService').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ action("AdminControllers\Master\VehicleServiceController@index") }}',
            "columns": [
                {data: 'title', name: 'title'},
                {data: 'clientid', name: 'clientid'},
                {data: 'action', name: 'action'},
            ],
        });
    </script>
@endsection