@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-body">
                    <center>
                        <h4>{{ $Vehicle->vehicleNumber }} {{ date('F', mktime(0, 0, 0, $Month, 10)) }} {{ $Year }} Profit / Expense</h4>
                        <div class="row">
                           <div class="col-sm-3">
                              <div class="info-box bg-green">
                                 <span class="info-box-icon"><i class="fa fa-pie-chart"></i></span>
                                 <div class="info-box-content">
                                    <span class="info-box-text">Profit</span>
                                    <span class="info-box-number">{{ auth()->user()->CalculateProfitAmountTotal($Vehicle->id,$Month,$Year) }}</span>
                                   {{--  <div class="progress">
                                       <div class="progress-bar" style="width: 70%"></div>
                                    </div> --}}
                                    <span class="progress-description">
                                        
                                    </span>
                                 </div>
                              </div>
                           </div>
                            <div class="col-sm-3">
                              <div class="info-box bg-red">
                                 <span class="info-box-icon"><i class="fa fa-ils"></i></span>
                                 <div class="info-box-content">
                                    <span class="info-box-text">Expense</span>
                                    <span class="info-box-number">{{ auth()->user()->CalculateNonTripExpenseAmountTotal($Vehicle->id,$Month,$Year) }}</span>
                                   {{--  <div class="progress">
                                       <div class="progress-bar" style="width: 50%"></div>
                                    </div> --}}
                                    <span class="progress-description">
                                        
                                    </span>
                                 </div>
                              </div>
                           </div>
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>


    @if(!$Trips->isEmpty())
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="table-responsive">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(!$ExtraIncomes->isEmpty())
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="table-responsive">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(!$Expenses->isEmpty())
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table  class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Expense Type</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Expenses as $Expense)
                                        <tr>
                                            <td>{{ date("d-m-Y", strtotime($Expense->date)) }}</td>
                                            <td>{{ $Expense->ExpenseType->expenseType }}</td>
                                            <td>{{ $Expense->amount }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection