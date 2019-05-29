@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-body">
                    <center>
                        <h4>{{ date('F', mktime(0, 0, 0, $Month, 10)) }} {{ $Year }} Expense</h4>
                        <h4><span style="color: green;font-size: 25px"><i class="fa fa-rupee"></i> {{ auth()->user()->CalculateNonTripExpenseAmountTotal('',$Month,$Year) }}</span></h4>
                    </center>
                </div>
            </div>
        </div>
    </div>

    <?php $Icon = array('truck','rupee'); ?>
    <div class="row">
        @foreach(Auth::user()->vehicles as $vehicle)
            @if(($Profit = auth()->user()->CalculateNonTripExpenseAmountTotal($vehicle->id,$Month,$Year)) > 0)
                <a href="{{ route('client.DashboardVehicleNonTripExpenseList',[$vehicle->id,$Month,$Year]) }}">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-red">
                            <span class="info-box-icon"><i class="fa fa-{{$Icon[array_rand($Icon,1)]}}"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-number">{{ $vehicle->vehicleNumber }}</span>
                                <span class="info-box-text">{{ $Profit }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endif
        @endforeach
    </div>

@endsection