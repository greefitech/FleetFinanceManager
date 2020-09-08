@extends('client.layout.master')

@section('content')

@php
    $PrevM =  Carbon\Carbon::parse($Year.'-'.$Month)->subMonth()->format('m'); 
    $PrevY =  Carbon\Carbon::parse($Year.'-'.$Month)->subMonth()->format('Y'); 
    $NextM =  Carbon\Carbon::parse($Year.'-'.$Month)->addMonthsNoOverflow(1)->format('m'); 
    $NextY =  Carbon\Carbon::parse($Year.'-'.$Month)->addMonthsNoOverflow(1)->format('Y'); 
@endphp

    <ul class="pager">
        <li class="previous"><a href="{{ action('ClientController\DashboardController@DashboardVehicleProfitTotal',[$PrevM,$PrevY]) }}">&laquo; Previous</a></li>
        <li class="next"><a href="{{ action('ClientController\DashboardController@DashboardVehicleProfitTotal',[$NextM,$NextY]) }}">Next &raquo;</a></li>
    </ul>

  <div class="row">
     <div class="col-xs-12">
        <div class="box box-info">
           <div class="box-body">
              <center>
                 <h4>{{ date('F', mktime(0, 0, 0, $Month, 10)) }} {{ $Year }} Profit / Expense</h4>
                 <div class="row">
                    <div class="col-sm-3">
                       <div class="info-box bg-blue">
                          <span class="info-box-icon"><i class="fa fa-pie-chart"></i></span>
                          <div class="info-box-content">
                             <span class="info-box-text">Income</span>
                             <span class="info-box-number">₹ {{ $IncomeAmount = auth()->user()->CalculateProfitAmountTotal('',$Month,$Year) }}</span>
                             {{-- <div class="progress">
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
                             <span class="info-box-number">₹ {{ $ExpenaeAmount = auth()->user()->CalculateNonTripExpenseAmountTotal('',$Month,$Year) }}</span>
                             {{-- <div class="progress">
                                <div class="progress-bar" style="width: 50%"></div>
                             </div> --}}
                             <span class="progress-description">
                             </span>
                          </div>
                       </div>
                    </div>
                    <div class="col-sm-3">
                       <div class="info-box bg-green">
                          <span class="info-box-icon"><i class="fa fa-money"></i></span>
                          <div class="info-box-content">
                             <span class="info-box-text">Profit</span>
                             <span class="info-box-number">₹ {{ $IncomeAmount - $ExpenaeAmount }}</span>
                             {{-- <div class="progress">
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

  

    <?php $Icon = array('truck','truck'); ?>
    <div class="row">
        @foreach(Auth::user()->vehicles as $vehicle)
        @php
            $Profit = auth()->user()->CalculateProfitAmountTotal($vehicle->id,$Month,$Year);
            $NonExpense = auth()->user()->CalculateNonTripExpenseAmountTotal($vehicle->id,$Month,$Year);
        @endphp
            @if($Profit > 0 || $NonExpense>0)
          <a href="{{ route('client.DashboardVehicleProfitList',[$vehicle->id,$Month,$Year]) }}">
            <div class="col-sm-3">
               <div class="info-box bg-{{ ($Profit>$NonExpense)?'green':'red' }}" style="box-shadow: 7px -7px #ffffff;">
                  <span class="info-box-icon" style="height: 132px;font-size: 63px;"><i class="fa fa-{{$Icon[array_rand($Icon,1)]}}"></i></span>
                  <div class="info-box-content"><strong>{{ $vehicle->vehicleNumber }}</strong>
                     <span class="info-box-text">Income</span>
                     <span class="info-box-number">₹ {{ $Profit }}</span>
                     <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                     </div>
                     <span class="progress-description">
                        <span class="info-box-text">Expense</span>
                        <span class="info-box-number">₹ {{ $NonExpense }}</span>
                     </span>
                  </div>
               </div>
            </div>
          </a>
                      

{{-- 
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="panel-group">
                        <div class="panel panel-success">
                            <div class="panel-heading"><a href="{{ route('client.DashboardVehicleProfitList',[$vehicle->id,$Month,$Year]) }}">{{ $vehicle->vehicleNumber }}</a></div>
                            <div class="panel-body">
                                <ul class="list-group">
                                    <li class="list-group-item">Profit : <b style="color: green;">{{ $Profit }}</b></li>
                                    <li class="list-group-item">Expense : <b style="color: red;">{{ $NonExpense }}</b></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> --}}
            @endif
        @endforeach
    </div>

@endsection