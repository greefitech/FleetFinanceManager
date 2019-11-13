@extends('manager.layout.master')

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
                                @php
                                    $CustomerBalance = $Customer->customerEntryData->whereIn('vehicleId',auth()->user()->Vehicles()->pluck('id'))->sum('balance') - $Customer->customerIncomeData->whereIn('vehicleId',auth()->user()->Vehicles()->pluck('id'))->sum('recevingAmount') - $Customer->customerIncomeData->whereIn('vehicleId',auth()->user()->Vehicles()->pluck('id'))->sum('discountAmount');
                                @endphp
                                    @if($CustomerBalance != 0)
                                        <tr>
                                            <td>{{ $Customer->name }}</td>
                                            <td>{{ $Customer->mobile }}</td>
                                            <td>{{ $Customer->address }}</td>
                                            <td>{{ $Customer->type }}</td>
                                            <th>{{ $CustomerBalance }}</th>
                                            <td><a href="{{ route('manager.AddCustomerIncome',$Customer->id) }}" class="btn btn-info btn-sm">Add Income</a></td>
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