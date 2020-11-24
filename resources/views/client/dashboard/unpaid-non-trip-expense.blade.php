@extends('client.layout.master')

@section('content')

<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Un Paid Expense</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table  class="table table-bordered table-striped DataTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Vehicle</th>
                                <th>Expense Type</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="row_position">
                        	 @foreach($Expenses as $Expense)
                                <tr id="{{ $Expense->id }}">
                                    <td>{{ date("d-m-Y", strtotime($Expense->date)) }}</td>
                                    <td>{{ $Expense->vehicles->vehicleNumber }}</td>
                                    <td>{{ $Expense->ExpenseType->expenseType }}</td>
                                    <td>{{ $Expense->amount }}</td>
                                    <td>
                                        <a href="{{ action('ClientController\ExpenseController@EditNonTripExpense',$Expense->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $( ".row_position" ).sortable({
        delay: 150,
        stop: function() {
            var selectedData = new Array();
            $('.row_position>tr').each(function() {
                selectedData.push($(this).attr("id"));
            });
            updateOrder(selectedData);
        }
    });


    function updateOrder(data) {
        console.log(data);
    }
</script>
@endsection