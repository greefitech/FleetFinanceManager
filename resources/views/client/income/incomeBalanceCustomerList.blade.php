@extends('client.layout.master')

@section('IncomeMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Income Balance</center>
                    </h4>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table  class="table table-bordered table-striped DataTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Type</th>
                                    <th>Balance Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(auth()->user()->customers as $Customer)
                                    @if(($total = $Customer->customerEntryData->sum('balance')-$Customer->customerIncomeData->sum('recevingAmount')-$Customer->customerIncomeData->sum('discountAmount'))!= 0)
                                        <tr>
                                            <td>{{ $Customer->name }}</td>
                                            <td>{{ $Customer->mobile }}</td>
                                            <td>{{ $Customer->address }}</td>
                                            <td>{{ $Customer->type }}</td>
                                            <th>{{ $total }}</th>
                                            <td><a href="{{ route('client.AddCustomerIncome',$Customer->id) }}" class="btn btn-info btn-sm">Add Income</a></td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection