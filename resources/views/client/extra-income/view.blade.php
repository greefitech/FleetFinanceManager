@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Extra Income List <span style="color: green;">{{ $Vehicle->vehicleNumber }}</span></center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$ExtraIncomes->isEmpty())
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Income Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ExtraIncomes as $ExtraIncome)
                                        <tr>
                                            <td>{{ date("d-m-Y", strtotime($ExtraIncome->date)) }}</td>
                                            <td>{{ $ExtraIncome->ExpenseType->expenseType }}</td>
                                            <td>{{ $ExtraIncome->amount }}</td>
                                            <td><span class="label label-{{ ($ExtraIncome->status == 0)?'danger':'success' }}">{{ ($ExtraIncome->status == 0)?'Not Paid':'Paid' }}</span></td>
                                            <td>{{ (!empty($ExtraIncome->managerid))?$ExtraIncome->manager->name:auth()->user()->name }}</td>
                                            <td>
                                                <form action="{{ route('client.DeleteExtraIncome',$ExtraIncome->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a href="{{ route('client.EditExtraIncome',$ExtraIncome->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                                    <button href="" onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Customer till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection