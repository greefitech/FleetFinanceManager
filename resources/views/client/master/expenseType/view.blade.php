@extends('client.layout.master')

@section('MasterMenu','active')

@push('BreadCrumbMenu')
   <li>Master</li>
   <li class="active"><a href="{{ action('ClientController\ExpenseTypeController@index') }}">Income~Expense Type</a></li>
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">

            @component('client.layout.component.panel-head',['MenuTitle'=>'Expense / Income Types','Title'=>'Expense / Income Types List','color'=>env('TABPANELCOLOR')])
                @slot('Button')
                     <a href="{{ action('ClientController\ExpenseTypeController@create') }}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Type</a>
                @endslot

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


            @endcomponent

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