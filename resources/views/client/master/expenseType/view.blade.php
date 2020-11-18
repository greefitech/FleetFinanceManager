@extends('client.layout.master')

@section('MasterMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Expense / Income Types</center>
                    </h4>
                    <a href="{{ action('ClientController\ExpenseTypeController@create') }}" class="btn btn-info pull-right">Add Type</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table  class="table table-bordered table-striped table-hover" id="ExpenseTable">
                            <thead>
                                <tr>
                                    <th>Expense / Income Type</th>
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
    var Vehicles= $('#ExpenseTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ action('ClientController\ExpenseTypeController@index') }}',
        "columns": [
            {data: 'expenseType', name: 'expenseType'},
            {data: 'created_by', name: 'created_by'},
            {data: 'action', name: 'action'},
        ]
    });
</script>
@endsection