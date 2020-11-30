@extends('client.layout.master')

@section('VendorPaymentMenu','active')

@push('BreadCrumbMenu')
   <li>Vendor Payment</li>
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">

            @component('client.layout.component.panel-head',['MenuTitle'=>'Vendor Payment List','Title'=>'Vendor Payment List','color'=>env('TABPANELCOLOR')])

                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="table-responsive">
                    <table  class="table table-bordered table-striped table-hover" id="DataTableList">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Vendor</th>
                                <th>Vehicle</th>
                                <th>Expense</th>
                                <th>Amount</th>
                                <th>Discount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	
                        </tbody>
                    </table>
                </div>

            @endcomponent

        </div>
    </div>
@endsection

@section('script')

<script>
    var Customer= $('#DataTableList').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ action('ClientController\vendorPayment\VendorPaymentListController@index') }}',
        "columns": [
            {data: 'date', name: 'date'},
            {data: 'vendor_id', name: 'vendor_id'},
            {data: 'vehicle', name: 'vehicle'},
            {data: 'expense_id', name: 'expense_id'},
            {data: 'amount', name: 'amount'},
            {data: 'discount', name: 'discount'},
            {data: 'action', name: 'action'},
        ],
        'rowCallback': function(row, data, index){
            if(data['discount'] != ''){
                $(row).find('td:eq(5)').css('color', 'red');
            }
            if(data['amount'] != ''){
                $(row).find('td:eq(4)').css('color', 'green');
            }
        }
    });

    $('#DataTableList').on('click', '.Delete', function (e) { 
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
                cancelButtonText: "No, cancel plx!",
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
                        Customer.ajax.reload();
                        swal("Deleted!", data.msg, data.status);
                    });
                } else {
                    swal("Cancelled", "Your Data is safe :)", "error");
                }
            });
        });
</script>

@endsection

