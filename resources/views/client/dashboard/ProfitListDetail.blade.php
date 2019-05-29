@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <center>
                <h4>{{ $Vehicle->vehicleNumber }} {{ date('F', mktime(0, 0, 0, $Month, 10)) }} {{ $Year }} Profit</h4>
                <h4><span style="color: green;font-size: 25px"><i class="fa fa-rupee"></i> {{ auth()->user()->CalculateProfitAmountTotal($Vehicle->id,$Month,$Year) }}</span></h4>
            </center>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$Trips->isEmpty())
                            <table  class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date From</th>
                                        <th>Date To</th>
                                        <th>Trip Name</th>
                                        <th>Profit Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Trips as $Trip)
                                        <tr>
                                            <td>{{ date("d-m-Y", strtotime($Trip->dateFrom)) }}</td>
                                            <td>{{ date("d-m-Y", strtotime($Trip->dateTo)) }}</td>
                                            <td>{{ $Trip->tripName }}</td>
                                            <td>{{ auth()->user()->TripTotalIncome($Trip->id) - auth()->user()->TripTotalExpense($Trip->id) }}</td>
                                            <td>
                                                <a href="{{ route('client.DownloadTripSheet',$Trip->id) }}" class="btn btn-primary btn-sm">View Trip Sheet</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Trip till now!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$ExtraIncomes->isEmpty())
                            <table  class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Income Type</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ExtraIncomes as $ExtraIncome)
                                        <tr>
                                            <td>{{ date("d-m-Y", strtotime($ExtraIncome->date)) }}</td>
                                            <td>{{ $ExtraIncome->ExpenseType->expenseType }}</td>
                                            <td>{{ $ExtraIncome->amount }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Extra Income till now!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection