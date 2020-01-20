@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Vehicles List</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table  class="table table-bordered table-striped" id="NontripExpense">
                            <thead>
                                <tr>
                                    <th>Owner Name</th>
                                    <th>Vehicle Number</th>
                                    <th>Vehicle Name</th>
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
    var Vehicles= $('#NontripExpense').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ action('ClientController\ExpenseController@ExpenseVehcleListNonTrip') }}',
        "columns": [
            {data: 'ownerName', name: 'ownerName'},
            {data: 'vehicleNumber', name: 'vehicleNumber'},
            {data: 'vehicleName', name: 'vehicleName'},
            {data: 'action', name: 'action'},
        ]
    });
</script>
@endsection