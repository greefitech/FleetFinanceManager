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
                        <p>Total Amount </p>
                        <?php $sum = 0; ?>
                        @foreach($Clients as $Client)
                            @foreach($Client->TotalIncome as $TotalIncome)
                                @php($sum += $TotalIncome->total_amount)
                            @endforeach
                        @endforeach

                        <h3 id="total_amount">{{ $sum }}</h3>
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
                        <?php $sum = 0; ?>
                        @foreach($Clients as $Client)
                            @foreach($Client->TotalIncome as $TotalIncome)
                                @php($sum += $TotalIncome->paid_amount)
                            @endforeach
                        @endforeach
                        <h3 id="paid_amount">{{ $sum }}</h3>
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
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <p>Admin Wise </p>
                        <?php $count = 0; ?>
                        @foreach($Admins as $Admin)
                            @if(!empty($Admin->mobile))
                                @php($count++)
                            @endif
                        @endforeach
                        <h3>{{ $count }}</h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('admin.TotalAdminWise') }}" class="small-box-footer">More info<i class="fa fa-arrow-circle-right"></i></a>
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
                    <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <p>Total Amount </p>
                        <?php $sum = 0; ?>
                        @foreach($Clients as $Client)
                            @foreach($Client->TotalIncome as $TotalIncome)
                                @php($sum += $TotalIncome->total_amount)
                            @endforeach
                        @endforeach

                        <h3 id="total_amount">{{ $sum }}</h3>
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
                        <?php $sum = 0; ?>
                        @foreach($Clients as $Client)
                            @foreach($Client->TotalIncome as $TotalIncome)
                                @php($sum += $TotalIncome->paid_amount)
                            @endforeach
                        @endforeach

                        <h3 id="paid_amount">{{ $sum }}</h3>
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

@section('script')

    <script>

        $(document).ready(function() {
            var total_amount = $('#total_amount').text();
            var paid_amount = $('#paid_amount').text();
            var sum = parseInt(total_amount) - parseInt(paid_amount);
            $('#OutStanding').text(sum);
        });


    </script>

@endsection

