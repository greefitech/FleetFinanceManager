@extends('admin.layout.master')

@section('content')
    @if(auth()->user()->id ==1 )
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <p>Total Client</p>
                        <h3>{{ $Clients->count() }}</h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <p>Total Amount</p>
                        <h3 id="total_amount">{{ $VehicleCredits->sum('total_amount') }}</h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <p>Income</p>
                        <h3>{{ @$VehicleCredits->sum('paid_amount') }}</h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <p>OutStanding </p>
                        <h3>{{ $VehicleCredits->sum('total_amount') - @$VehicleCredits->sum('paid_amount') }}</h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <p>Admin List </p>
                        <h3>{{ $Admins }}</h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('admin.DashboardAdminList') }}" class="small-box-footer">More info<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    @endif


    @if(auth()->user()->id != 1 )
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <p>Total Client </p>
                        <h3>{{ $Clients->count() }}</h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('admin.AdminClientWise',auth()->user()->id) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <p>Total Amount </p>
                        <?php $total_amount = 0; ?>
                        @foreach($Clients as $Client)
                            @foreach($Client->TotalIncome as $TotalIncome)
                                @php($total_amount += $TotalIncome->total_amount)
                            @endforeach
                        @endforeach

                        <h3 id="total_amount">{{ $total_amount }}</h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <p>Income </p>
                        <?php $paid_amount = 0; ?>
                        @foreach($Clients as $Client)
                            @foreach($Client->TotalIncome as $TotalIncome)
                                @php($paid_amount += $TotalIncome->paid_amount)
                            @endforeach
                        @endforeach

                        <h3 id="paid_amount">{{ $paid_amount }}</h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <p>OutStanding </p>
                        <h3 id="OutStanding"></h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    @endif

@endsection


