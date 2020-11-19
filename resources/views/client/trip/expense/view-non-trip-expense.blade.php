@extends('client.layout.master')

@section('NonTripExpenseMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4><center>{{ $Vehicle->vehicleNumber }} Expense List</center></h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$Expenses->isEmpty())
                            <meta name="csrf-token" content="{{ csrf_token() }}" />
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="deleteCheck">
                                            <button type="button" id="deleteButton" class="btn btn-primary btn-sm"><i class="fa fa-trash-o"></i> Delete</button>
                                        </th>
                                        <th style="width:100px">Date</th>
                                        <th style="width:200px">Expense Type</th>
                                        <th>Location</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Description</th>
                                        {{-- <th>Created By</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Expenses as $Expense)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="delete_exp[]" value="{{ $Expense->id }}" class="deleteMultiple">
                                            </td>
                                            <td>{{ date("d-m-Y", strtotime($Expense->date)) }}</td>
                                            <td>{{ $Expense->ExpenseType->expenseType }}</td>
                                            <td>{{ $Expense->location }}</td>
                                            <td>{{ $Expense->quantity }}</td>
                                            <td>{{ $Expense->amount }}</td>
                                            <td><span class="label label-{{ ($Expense->status == 0)?'danger':'success' }}">{{ ($Expense->status == 0)?'Not Paid':'Paid' }}</span></td>
                                            <td>{{ $Expense->discription }}</td>
                                            {{-- <td>-</td> --}}
                                            <td>
                                                <form action="{{ route('client.DeleteExpense',$Expense->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a href="{{ action('ClientController\ExpenseController@EditNonTripExpense',$Expense->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                                    <button href="" onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Expense till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

<script type="text/javascript">
$(document).ready(function(){
    $('#deleteCheck').on('click',function(){
        if ($(this).is(':checked')) {
            $(".deleteMultiple").each(function() {
                $(this).prop('checked',true);
            });
        }else{
            $(".deleteMultiple").each(function() {
                $(this).prop('checked',false);
            });
        }
    })

    $('#deleteButton').on('click',function(){
        var exp_id = [];
        $("input:checkbox[class=deleteMultiple]:checked").each(function () {
            exp_id.push($(this).val());
        });
        if(exp_id.length > 0){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var confirmdelete = confirm("Do you really want to Delete records?");
            if (confirmdelete == true) {
                $.ajax({
                    url: '{{ action("ClientController\ExpenseController@DeleteMultipleNonTripExpense") }}',
                    type: 'post',
                    data: {_token: CSRF_TOKEN,exp_id: exp_id},
                    success: function(data){
                        if (data.status =='success') {
                            toastr.success('Expenses', 'Deleted Successfully!!!');
                            location.reload();
                        }else{
                            toastr.warning('Expense Not Deleted Some Thing Went Wrong!!');
                        }
                    }
                });
            } 
        }
    })
});
</script>

@endsection